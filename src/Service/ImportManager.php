<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Material;
use App\Entity\Product;
use App\Entity\Type;
use App\Helper\SlugHelper;
use App\Model\Admin\ProductImport;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use RuntimeException;
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
        $spreadsheet = $this->xlsxReader->load($productImport->getXlsFile());
        $sheetData   = $spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, true);
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
        
        $this->importImages($productImport);
        
        return [$created, $updated];
    }
    
    private function generateProductUri(ProductImport $productImport, string $productName): string
    {
        $catalogName = preg_replace('/\s+/', ' ', $productImport->getCatalog()->getName());
        $nameForSlug = str_replace($catalogName, '', $productName);
        if (!empty($productImport->getRemoveFromName())) {
            $nameForSlug = str_replace($productImport->getRemoveFromName(), '', $productName);
        }
    
        return $productImport->getCatalog()->getUri() . '/' . SlugHelper::makeSlug($nameForSlug);
    }
    
    private function importImages(ProductImport $productImport): void
    {
        $imgFolder = $this->productImgFolder($productImport);
        
        if (null !== $productImport->getImagesSmall()) {
            $zip = new ZipArchive();
            $zip->open($productImport->getImagesSmall()->getRealPath());
            $zip->extractTo($imgFolder . 'small/');
            $zip->close();
        }
        
        if (null !== $productImport->getImagesBig()) {
            $zip = new ZipArchive();
            $zip->open($productImport->getImagesBig()->getRealPath());
            $zip->extractTo($imgFolder . 'big/');
            $zip->close();
        }
        
        if (null !== $productImport->getImagesCatalog()) {
            $zip = new ZipArchive();
            $zip->open($productImport->getImagesCatalog()->getRealPath());
            $zip->extractTo($imgFolder . 'catalog/');
            $zip->close();
        }
    }
    
    private function productImgFolder(ProductImport $productImport): string
    {
        $segments = explode('/', $productImport->getCatalog()->getUri());
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
            ->setUri($this->generateProductUri($productImport, $productName));
        $this->entityManager->persist($product);
        
        return $product;
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
}