<?php

namespace App\EntityListener;

use App\Entity\Geo;
use App\Service\ConfigService;

class GeoListener
{
    public function __construct(private ConfigService $configService)
    {
    }
    
    public function postLoad(Geo $geo)
    {
        $price = $this->configService->getCached('geo.' . $geo->getGeoProductType());
        $geo->getGeoProduct()->setPrice($price);
    }
}