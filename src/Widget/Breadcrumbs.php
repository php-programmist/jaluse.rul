<?php

namespace App\Widget;

use App\Entity\Page;
use App\Service\BreadcrumbsService;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Breadcrumbs extends AbstractExtension
{
    
    public function __construct(private BreadcrumbsService $breadcrumbsService)
    {
    
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('breadcrumbs', [$this, 'render'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }
    
    public function render(Environment $twig, ?Page $page)
    {
        if (null === $page) {
            return '';
        }
        $items = $this->breadcrumbsService->getItems($page);
        if (empty($items)) {
            return '';
        }
        
        return $twig->render('modules/breadcrumbs.html.twig', [
            'items' => $items,
        ]);
    }
}
