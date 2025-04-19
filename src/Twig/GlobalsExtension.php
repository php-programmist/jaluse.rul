<?php

namespace App\Twig;

use App\Service\ConfigService;
use App\Service\SubDomainService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalsExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private SubDomainService $subDomainService,
        private ConfigService $configService,
    )
    {
    }
    
    public function getGlobals(): array
    {
        return [
            'isMainDomain' => $this->subDomainService->isMainDomain(),
            'isHidePhone' => $this->configService->getCached('hide_phone'),
        ];
    }
}