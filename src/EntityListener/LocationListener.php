<?php

namespace App\EntityListener;

use App\Entity\Location;
use App\Service\ConfigService;

class LocationListener
{
    public function __construct(private ConfigService $configService)
    {
    }
    
    public function postLoad(Location $location)
    {
        $price = $this->configService->getCached('geo.' . $location->getGeoProductType());
        $location->setPrice($price);
    }
}