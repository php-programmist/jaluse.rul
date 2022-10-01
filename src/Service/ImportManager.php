<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Location;
use App\Entity\Material;
use App\Entity\Product;
use App\Entity\Type;
use App\Helper\SlugHelper;
use App\Model\Admin\LocationImport;
use App\Model\Admin\ProductImport;
use App\Model\Admin\SlugConfig;
use App\Model\Admin\UpdatePrices;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZipArchive;

class ImportManager
{
    private EntityManagerInterface $entityManager;
    private Xlsx $xlsxReader;
    private string $projectDir;
    
    public function __construct(
        EntityManagerInterface $entityManager,
        Xlsx $xlsxReader,
        string $projectDir
    ) {
        $this->entityManager = $entityManager;
        $this->xlsxReader    = $xlsxReader;
        $this->projectDir    = $projectDir;
    }
    
    public function importProducts(ProductImport $productImport): array
    {
        $sheetData   = $this->getSheetData($productImport->getXlsFile());
        $created     = [];
        $updated     = [];
        $productRepo = $this->entityManager->getRepository(Product::class);
        foreach ($sheetData as $row_number => $row) {
            if ($row_number < $productImport->getFirstRow()) {
                continue;
            }
            [
                "A" => $imageName,
                "B" => $productName,
                "C" => $colorName,
                "D" => $price,
                "E" => $categoryName,
            ] = $row;
            $popular = isset($row['F']) ? (bool)$row['F'] : null;
    
            if (empty($productName)) {
                break;
            }
            $product = $productRepo->findOneBy(['name' => $productName, 'parent' => $productImport->getCatalog()]);
            if (null === $product) {
                $product   = $this->initProduct($productName, $productImport);
                $created[] = $product->getPath();
            } else {
                $updated[] = $product->getPath();
            }
    
            $this->setColor($colorName, $product);
            $this->setCategory($categoryName, $product);
            $this->setImages($imageName, $product);
            $this->setPopular($popular, $product);
    
            if ($productImport->isMatrix()) {
                $this->setMatrix($price, $product);
            } else {
                $this->setPrice($price, $product);
            }
        
            $this->setType($productImport->getType(), $product);
            $this->setMaterial($productImport->getMaterial(), $product);
        
        }
        $this->entityManager->flush();
    
        $imgFolder = $this->productImgFolder($productImport);
    
        $this->importImages(
            $productImport->getImagesSmall(),
            $imgFolder . 'small/'
        );
    
        $this->importImages(
            $productImport->getImagesBig(),
            $imgFolder . 'big/'
        );
    
        $this->importImages(
            $productImport->getImagesCatalog(),
            $imgFolder . 'catalog/'
        );
    
        return [$created, $updated];
    }
    
    public function importLocations(LocationImport $locationImport): array
    {
        $sheetData    = $this->getSheetData($locationImport->getXlsFile());
        $created      = [];
        $updated      = [];
        $locationRepo = $this->entityManager->getRepository(Location::class);
        foreach ($sheetData as $row_number => $row) {
            if ($row_number < $locationImport->getFirstRow()) {
                continue;
            }
            [
                "A" => $name,
                "B" => $h1,
                "C" => $locationName,
                "D" => $imageName,
            ] = $row;
            
            if (empty($name)) {
                break;
            }
            $location = $locationRepo->findOneBy(['name' => $name, 'baseCatalog' => $locationImport->getCatalog()]);
            if (null === $location) {
                $location  = $this->initLocation($name, $locationImport);
                $created[] = $location->getPath();
            } else {
                $updated[] = $location->getPath();
            }
            
            $location
                ->setH1($h1 ? : null)
                ->generateDescription()
                ->generateTitle()
                ->generateCardDescription($locationImport, $locationName)
                ->setCardImage($imageName);
        }
        $this->entityManager->flush();
        
        $this->importImages(
            $locationImport->getImages(),
            $this->projectDir . '/public_html/img/location/');
        
        return [$created, $updated];
    }
    
    public function updatePrices(UpdatePrices $updatePricesDto): array
    {
        $spreadsheet = $this->xlsxReader->load($updatePricesDto->getXlsFile());
        $updated     = [];
        $notFound    = [];
        $productRepo = $this->entityManager->getRepository(Product::class);
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $sheetData = $sheet->toArray(null, true, true, true);
            foreach ($sheetData as $row_number => $row) {
                [
                    "A" => $url,
                    "B" => $price,
                ] = $row;
    
                if ($row_number < 2 || empty($url)) {
                    continue;
                }
    
                $uri = trim(parse_url($url, PHP_URL_PATH), ' /');
    
                $product = $productRepo->findOneBy(['uri' => $uri]);
                if (null === $product) {
                    $notFound[] = $url;
                } else {
                    $this->setPrice((float)$price, $product);
                    $updated[] = $product->getPath();
                }
            }
        }
        
        $this->entityManager->flush();
        
        return [$updated, $notFound];
    }
    
    private function generateUri(SlugConfig $config, string $productName): string
    {
        $catalogName = preg_replace('/\s+/', ' ', $config->getCatalog()?->getName());
        $search      = $config->getRemoveFromName() ? : $catalogName;
        
        $nameForSlug = str_replace($search, '', $productName);
        
        return $config->getBaseUri() . '/' . SlugHelper::makeSlug($nameForSlug);
    }
    
    private function importImages(?UploadedFile $zippedImages, string $folder): void
    {
        if (null === $zippedImages) {
            return;
        }
        
        $zip = new ZipArchive();
        $zip->open($zippedImages->getRealPath());
        $zip->extractTo($folder);
        $zip->close();
    }
    
    private function productImgFolder(ProductImport $productImport): string
    {
        $segments = explode('/', $productImport->getBaseUri());
        $folder   = array_pop($segments);
        
        return $this->projectDir . '/public_html/img/products/' . $folder . '/';
    }
    
    private function setColor($colorName, $product): void
    {
        if (!empty($colorName)) {
            $colorRepo = $this->entityManager->getRepository(Color::class);
            $color     = $colorRepo->findOneBy(['name' => $colorName]);
            if (null === $color) {
                throw new RuntimeException(sprintf('Цвет "%s" не найден', $colorName));
            }
            $product->setColor($color);
        }
    }
    
    private function setPopular(?bool $popular, Product $product): void
    {
        if (null !== $popular && null === $product->getId()) {
            $product->setPopular($popular);
        }
    }
    
    private function setCategory($categoryName, $product): void
    {
        if (!empty($categoryName)) {
            $category = $this->entityManager
                ->getRepository(Category::class)
                ->findOneBy(['name' => $categoryName]);
            if (null === $category) {
                throw new RuntimeException(sprintf('Категория "%s" не найдена', $categoryName));
            }
            $product->setCategory($category);
        }
    }
    
    private function initProduct($productName, ProductImport $productImport): Product
    {
        $product = (new Product())
            ->setName($productName)
            ->setParent($productImport->getCatalog())
            ->setUri($this->generateUri($productImport, $productName));
        $this->entityManager->persist($product);
        
        return $product;
    }
    
    private function initLocation($name, LocationImport $locationImport): Location
    {
        $location = (new Location())
            ->setName($name)
            ->setParent($locationImport->getParent())
            ->setBaseCatalog($locationImport->getCatalog())
            ->setUri($this->generateUri($locationImport, $name));
        
        $this->entityManager->persist($location);
        
        return $location;
    }
    
    private function setImages($imageName, $product): void
    {
        if (!empty($imageName)) {
            $product
                ->setImageSmallName($imageName)
                ->setImageBigName($imageName)
                ->setImageCatalogName($imageName);
        }
    }
    
    private function setPrice($price, $product): void
    {
        if (!empty($price)) {
            $product->setPrice($price);
        }
    }
    
    private function setType(?Type $type, $product): void
    {
        if ($type !== null) {
            $product->setType($type);
        }
    }
    
    private function setMaterial(?Material $material, $product): void
    {
        if (null !== $material) {
            $product->setMaterial($material);
        }
    }
    
    private function setMatrix(mixed $matrixId, Product $product): void
    {
        if (!empty($matrixId)) {
            $product->setMatrixId($matrixId);
        }
    }
    
    private function getSheetData(UploadedFile $xlsFile): array
    {
        $spreadsheet = $this->xlsxReader->load($xlsFile);
        
        return $spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, true);
    }
}