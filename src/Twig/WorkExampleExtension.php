<?php

namespace App\Twig;

use App\Entity\Page;
use App\Service\WorkExampleService;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WorkExampleExtension extends AbstractExtension
{
    
    public function __construct(
        private WorkExampleService $workExampleService
    ) {
    
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('work_example', [$this, 'render'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }
    
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function render(Environment $twig, ?Page $page = null, bool $withFilters = false): string
    {
        $items = $this->workExampleService->getByPage($page);
        if (0 === count($items)) {
            return '';
        }
        if ($withFilters) {
            $html = $twig->render('modules/work_example/work_example_with_filters.html.twig', [
                'items' => $items,
            ]);
        } else {
            $html = $twig->render('widget/work_example.html.twig', [
                'items' => $items,
            ]);
        }
    
        return $html;
    }
}
