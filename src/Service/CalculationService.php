<?php

namespace App\Service;

use App\Entity\Product;

class CalculationService
{
    
    protected $usd_rate;
    /**
     * @var MatrixService
     */
    protected $matrix_service;
    
    public function __construct(ConfigService $config_service, MatrixService $matrix_service)
    {
        $this->matrix_service = $matrix_service;
        $this->usd_rate       = $config_service->getCached('usd_rate');
    }
    
    public function getMinPrice(Product $product): int
    {
        $type = $product->getType();
        if ( ! $type) {
            return 0;
        }
        if ($product->getPrice() && $type->getCalculationType() === 'simple') {
            return round($this->usd_rate * $product->getPrice());
        }
        if ($type->getCalculationType() === 'matrix') {
            $matrix    = $this->matrix_service->getMatrix($product->getMatrixFolder(), $product->getMatrixId());
            $min_width = current($matrix);
            $min_price = current($min_width);
            
            return round($this->usd_rate * $min_price);
        }
        
        return 0;
    }
}