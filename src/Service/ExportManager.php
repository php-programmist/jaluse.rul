<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Product;
use App\Model\Admin\ProductExport;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    
    }
    
    public function exportProducts(ProductExport $productExport): array
    {
        $catalog = $productExport->getCatalog();
        
        $spreadsheet = new Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(70);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(30);
        
        $sheet->fromArray(['URL', 'Название', 'Цвет', 'Родитель', 'Тип', 'Подтип', 'Категория', 'Цена']);
        
        $products = $this->getProductsData($catalog);
        foreach ($products as $index => $product) {
            $rowNumber = $index + 2;
            $sheet->fromArray($product, null, 'A' . $rowNumber);
        }
        
        $writer = new Xlsx($spreadsheet);
        
        $fileName  = sprintf('products_%s.xlsx', date('Y-m-d_H:i:s'));
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        $writer->save($temp_file);
        
        return [$temp_file, $fileName];
    }
    
    private function getProductsData(?Catalog $catalog): array
    {
        $products = $this->entityManager->getRepository(Product::class)->getAllOrByCatalog($catalog);
        
        $data = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $data[] = [
                $product->getPath(),
                $product->getName(),
                $product->getColor()?->getName(),
                $product->getParent()?->getName(),
                $product->getType()?->getName(),
                $product->getMaterial(),
                $product->getCategoryName(),
                $product->getPrice() ? : $product->getMatrixId(),
            ];
        }
        
        return $data;
    }
}