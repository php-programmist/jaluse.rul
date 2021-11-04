<?php

namespace App\Controller\Api;

use App\Service\CatalogManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/api/search", name="api_search")
     */
    public function search(Request $request, CatalogManager $catalogManager): Response
    {
        $filters['search'] = $request->query->get('search', '');
        
        return $this->render('catalog-search/results.html.twig', [
            'products' => $catalogManager->getProductsPaginator($filters, 10),
        ]);
    }
    
}