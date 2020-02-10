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
    private $matrices;
    
    public function __construct(ConfigService $config_service, MatrixService $matrix_service)
    {
        $this->matrix_service = $matrix_service;
        $this->usd_rate       = $config_service->getCached('calc.usd_rate');
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
            if (! $this->matrices) {
                $this->matrices = $this->matrix_service->getAllCachedMatrices();
            }
            $matrix    = $this->matrices[$product->getMatrixFolder()][$product->getMatrixId()];
            $min_width = current($matrix);
            $min_price = current($min_width);
            
            return round($this->usd_rate * $min_price);
        }
        
        return 0;
    }
    
    /**
     * @param Product[] $products
     */
    public function setMinPriceForAll(array $products)
    {
        foreach ($products as $product) {
            $product->setMinPrice($this->getMinPrice($product));
        }
    }
}