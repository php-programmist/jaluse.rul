<?php

namespace App\EntityListener;

use App\Entity\Geo;
use App\Service\CalculationService;

class GeoListener
{
    public function __construct(
        private CalculationService $calculation_service
    ) {
    }
    
    public function postLoad(Geo $geo)
    {
        $price           = $this->calculation_service->getCatalogMinPriceByUri($geo->getBaseCatalogUri());
        $discountedPrice = $this->calculation_service->getDiscountedPrice($price);
        $formattedPrice  = sprintf($geo->getPriceFormat(), $discountedPrice);
        $geo->getGeoProduct()->setPrice($formattedPrice);
    }
}