<?php

namespace App\Controller;

use App\Entity\Catalog;
use App\Repository\CategoryRepository;
use App\Repository\PageRepository;
use App\Repository\ProductRepository;
use App\Service\CatalogManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class YmlController extends AbstractController
{
    
    /**
     * @Route("/{token}.yml", name="dynamic_yaml",requirements={"token"=".+"}, format="xml")
     * @param string         $token
     * @param PageRepository $pageRepository
     * @param CatalogManager $catalogManager
     *
     * @return Response
     */
    public function dynamicYaml(
        string $token,
        PageRepository $pageRepository,
        CatalogManager $catalogManager
    ): Response {
        if (!$catalog = $pageRepository->findOneBy(['uri' => $token])) {
            throw new NotFoundHttpException();
        }
        if (!$catalog instanceof Catalog) {
            throw new NotFoundHttpException();
        }
        $offers = $catalogManager->getPopular($catalog);
        
        return $this->render('yml/index.xml.twig', [
            'offers' => $offers,
            'page'   => $catalog,
        ]);
    }
    
    /**
     * @Route("/ymarket.xml", name="ymarket", format="xml")
     *
     * @param ProductRepository  $productRepository
     * @param CategoryRepository $categoryRepository
     *
     * @return Response
     */
    public function ymarket(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('yml/ymarket.xml.twig', [
            'offers'     => $productRepository->getForYml(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/ymarket-cards.xml", name="ymarket_cards")
     *
     * @param ProductRepository $productRepository
     *
     * @return Response
     */
    public function ymarketCards(ProductRepository $productRepository)
    {
        return $this->render('yml/ymarket-cards.xml.twig', [
            'offers' => $productRepository->getForYml(),
        ]);
    }
}
