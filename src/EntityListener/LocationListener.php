<?php

namespace App\EntityListener;

use App\Entity\Location;
use App\Service\CalculationService;

class LocationListener
{
    public function __construct(private CalculationService $calculation_service)
    {
    }
    
    public function postLoad(Location $location)
    {
        $price           = $this->calculation_service->getCatalogMinPriceByUri($location->getBaseCatalogUri());
        $discountedPrice = $this->calculation_service->getDiscountedPrice($price);
        $formattedPrice  = sprintf($location->getPriceFormat(), $discountedPrice);
        $location->setPrice($formattedPrice);
    }
}