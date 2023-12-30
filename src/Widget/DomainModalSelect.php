<?php

namespace App\Widget;

use App\Service\SubDomainService;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DomainModalSelect extends AbstractExtension
{
    
    public function __construct(private SubDomainService $subDomainService)
    {
    
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('domain_modal', [$this, 'modal'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('domain_modal_trigger', [$this, 'trigger'],
                ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }
    
    public function modal(Environment $twig)
    {
        $items = $this->subDomainService->getSubdomains();
        if (empty($items)) {
            return '';
        }
        $currentSubDomain = $this->subDomainService->getSubdomainEntity();
        
        return $twig->render('modules/domain_modal.html.twig', [
            'items'            => $items,
            'currentSubDomain' => $currentSubDomain,
        ]);
    }
    
    public function trigger(Environment $twig)
    {
        $currentSubDomain = $this->subDomainService->getSubdomainEntity();
        
        return $twig->render('modules/domain_modal_trigger.html.twig', [
            'currentSubDomain' => $currentSubDomain,
        ]);
    }
}
