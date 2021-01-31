<?php

namespace App\Controller;

use App\Entity\Catalog;
use App\Entity\Location;
use App\Entity\Markiz;
use App\Entity\Product;
use App\Entity\Roll;
use App\Entity\Roman;
use App\Repository\PageRepository;
use App\Repository\ProductRepository;
use App\Service\CatalogManager;
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
    /**
     * @var CatalogManager
     */
    private $catalogManager;
    
    public function __construct(
        PageRepository $page_repository,
        ProductRepository $product_repository,
        ConfigService $configs,
        CatalogManager $catalogManager
    ) {
        $this->page_repository    = $page_repository;
        $this->product_repository = $product_repository;
        $this->configs            = $configs;
        $this->catalogManager = $catalogManager;
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
        } elseif ($page instanceof Location) {
            return $this->location($page);
        } elseif ($page instanceof Markiz || $page instanceof Roll) {
            return $this->render('simple_catalog/item.html.twig', [
                'page' => $page,
            ]);
        } elseif ($page instanceof Roman) {
            return $this->render('simple_catalog/item.html.twig', [
                'page' => $page,
                'area' => true,
            ]);
        }
        
        throw new NotFoundHttpException('Page is instance of ' . get_class($page));
    }
    
    private function product(Product $product)
    {
        $limit = 12;
        $items = $this->product_repository->getPopularSiblings($product,$limit);
        return $this->render('page/product.html.twig', [
            'page' => $product,
            'items' => $items,
        ]);
    }
    
    private function catalog(Catalog $catalog)
    {
        $force_show_filters = $catalog->getUri() === 'zhalyuzi';
        $show_calc = in_array($catalog->getUri(),['zhalyuzi','rulonnyie-shtoryi']);
        return $this->render('page/catalog.html.twig', [
            'page'  => $catalog,
            'items' => $this->catalogManager->getPopular($catalog),
            'force_show_filters' => $force_show_filters,
            'show_calc' => $show_calc,
        ]);
    }
    
    private function location(Location $location)
    {
        return $this->render('page/location.html.twig', [
            'page'  => $location,
            'items' => [],
        ]);
    }
}
