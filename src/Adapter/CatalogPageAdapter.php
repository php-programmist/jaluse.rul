<?php

namespace App\Adapter;

use App\Entity\Catalog;
use App\Entity\Contracts\TurboPageInterface;
use App\Entity\Roll;
use App\Service\CatalogManager;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CatalogPageAdapter extends RssPageAdapter
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CatalogManager
     */
    private $catalogManager;
    
    /**
     * @param Environment            $twig
     * @param EntityManagerInterface $entityManager
     * @param CatalogManager         $catalogManager
     */
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        CatalogManager $catalogManager
    ) {
        parent::__construct($twig);
        $this->entityManager = $entityManager;
        $this->catalogManager = $catalogManager;
    }
    
    /**
     * @param TurboPageInterface|Catalog $page
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function getText(TurboPageInterface $page): string
    {
        $catalog = [];
        $popular = [];
        if ($page->getUri() === 'rolstavni') {
            $catalog = $this->entityManager->getRepository(Roll::class)->findAll();
        } else {
            $popular = $this->catalogManager->getPopular($page, 8);
        }
    
        return $this->twig->render('turbo/catalog/content.html.twig', [
            'page'    => $page,
            'popular' => $popular,
            'catalog' => $catalog,
        ]);
    }
}