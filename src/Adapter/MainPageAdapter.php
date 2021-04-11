<?php

namespace App\Adapter;

use App\Entity\Catalog;
use App\Entity\Contracts\TurboPageInterface;
use App\Service\CatalogManager;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainPageAdapter extends RssPageAdapter
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
        $this->entityManager  = $entityManager;
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
        $catalog   = [];
        $catalog[] = $this->entityManager->getRepository(Catalog::class)->findOneBy(['uri' => 'zhalyuzi']);
        $catalog[] = $this->entityManager->getRepository(Catalog::class)->findOneBy(['uri' => 'rulonnyie-shtoryi']);
        $popular   = $this->catalogManager->getPopular($catalog[0], 8);
        
        return $this->twig->render('turbo/main/content.html.twig', [
            'page'    => $page,
            'popular' => $popular,
            'catalog' => $catalog,
        ]);
    }
}