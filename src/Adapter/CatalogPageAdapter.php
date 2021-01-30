<?php

namespace App\Adapter;

use App\Entity\Catalog;
use App\Entity\Contracts\TurboPageInterface;
use App\Service\CatalogManager;
use Doctrine\ORM\EntityManagerInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\BasePageInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\RssAdapterInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\RssItem;
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
        return $this->twig->render('turbo/catalog/content.html.twig', [
            'page' => $page,
            'popular' => $this->catalogManager->getPopular($page,8),
        ]);
    }
}