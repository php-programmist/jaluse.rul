<?php

namespace App\Controller;

use App\Entity\Catalog;
use App\Entity\Product;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    protected $page_repository;
    
    public function __construct(
        PageRepository $page_repository
    ) {
        $this->page_repository = $page_repository;
    }
    
    /**
     * @Route("/{token}/", name="dynamic_pages",requirements={"token"= ".+"})
     */
    public function index($token)
    {
        if ( ! $page = $this->page_repository->findOneBy(['uri' => $token])) {
            throw new NotFoundHttpException();
        }
        
        if ($page instanceof Product) {
            return $this->product($page);
        } elseif ($page instanceof Catalog) {
            return $this->catalog($page);
        }
        
        throw new NotFoundHttpException('Page is instance of ' . get_class($page));
    }
    
    private function product(Product $product)
    {
        return $this->render('page/product.html.twig', [
            'page' => $product,
        ]);
    }
    
    private function catalog(Catalog $catalog)
    {
        return $this->render('page/catalog.html.twig', [
            'page' => $catalog,
        ]);
    }
}
