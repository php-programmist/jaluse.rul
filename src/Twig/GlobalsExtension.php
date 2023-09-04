<?php

namespace App\Twig;

use App\Service\SubDomainService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalsExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private SubDomainService $subDomainService)
    {
    }
    
    public function getGlobals(): array
    {
        return [
            'isMainDomain' => $this->subDomainService->isMainDomain(),
        ];
    }
}