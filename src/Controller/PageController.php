<?php

namespace App\Controller;

use App\Entity\Catalog;
use App\Entity\Product;
use App\Repository\PageRepository;
use App\Repository\ProductRepository;
use App\Service\ConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    protected $page_repository;
    /**
     * @var ProductRepository
     */
    protected $product_repository;
    /**
     * @var ConfigService
     */
    protected $configs;
    
    public function __construct(
        PageRepository $page_repository,
        ProductRepository $product_repository,
        ConfigService $configs
    ) {
        $this->page_repository    = $page_repository;
        $this->product_repository = $product_repository;
        $this->configs            = $configs;
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
        $filters             = [];
        $filters['category'] = 1;
        if ($catalog->getType()) {
            $filters['type'] = $catalog->getType()->getId();
        }
        if ($catalog->getMaterial()) {
            $filters['material'] = $catalog->getMaterial()->getId();
        }
        $limit = 48;
        $items = $this->product_repository->findFiltered($filters, 0, $limit);
        
        return $this->render('page/catalog.html.twig', [
            'page'  => $catalog,
            'items' => $items,
        ]);
    }
}
