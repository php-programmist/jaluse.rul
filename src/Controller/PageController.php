<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Calculator;
use App\Entity\Catalog;
use App\Entity\Geo;
use App\Entity\Location;
use App\Entity\Markiz;
use App\Entity\Product;
use App\Entity\Roll;
use App\Entity\Roman;
use App\Repository\PageRepository;
use App\Repository\ProductRepository;
use App\Service\CatalogManager;
use App\Service\CategoryManager;
use App\Service\ColorManager;
use App\Service\ConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    protected PageRepository $page_repository;
    protected ProductRepository $product_repository;
    protected ConfigService $configs;
    private CatalogManager $catalogManager;
    private ColorManager $colorManager;
    private CategoryManager $categoryManager;
    private ?Request $request;
    
    public function __construct(
        PageRepository $page_repository,
        ProductRepository $product_repository,
        ConfigService $configs,
        CatalogManager $catalogManager,
        ColorManager $colorManager,
        CategoryManager $categoryManager,
        RequestStack $requestStack
    ) {
        $this->page_repository    = $page_repository;
        $this->product_repository = $product_repository;
        $this->configs            = $configs;
        $this->catalogManager     = $catalogManager;
        $this->colorManager       = $colorManager;
        $this->categoryManager    = $categoryManager;
        $this->request            = $requestStack->getCurrentRequest();
    }
    
    /**
     * @Route("/zhalyuzi/", name="catalog_zhalyuzi")
     */
    public function zhalyuzi()
    {
        /** @var Catalog $catalog */
        $catalog = $this->page_repository->findOneBy(['uri' => 'zhalyuzi']);
        
        
        $filters = $catalog->getFilters();
        if ($this->request->isXmlHttpRequest()) {
            return $this->catalogManager->renderProducts($filters);
        }
        $params = array_merge(
            $this->getCatalogRenderParams($catalog, $filters),
            [
                'force_show_filters' => true,
                'show_calc'          => true,
                'selected_type'      => $catalog->getType()?->getId(),
                'selected_material'  => $catalog->getMaterial()?->getId(),
                'available_types'    => $catalog->getAvailableTypes(),
            ]
        );
        
        unset($params['catalogsLinks']['Вертикальные']);
        $params['catalogsLinks']['Римские шторы'] = '/rimskies/';
        
        return $this->render('catalog/zhalyuzi/index.html.twig', $params);
    }
    
    /**
     * @Route("/{token}/color/{color}/", name="catalog_filter_color", requirements={"token"= ".+"})
     */
    public function colorFilter(string $token, string $color): Response
    {
        $catalog          = $this->catalogManager->findCatalogByUriOrFail($token);
        $selectedColor    = $this->colorManager->findColorByAliasOrFail($color);
        $filters          = $this->catalogManager->getBasicFiltersByCatalog($catalog);
        $filters['color'] = $selectedColor->getId();
        
        if ($this->request->isXmlHttpRequest()) {
            return $this->catalogManager->renderProducts($filters);
        }
        
        return $this->render('page/color-filtered-catalog.html.twig',
            array_merge(
                $this->getCatalogRenderParams($catalog, $filters),
                ['selectedColor' => $selectedColor]
            ));
    }
    
    /**
     * @Route("/{token}/sort/{category}/", name="catalog_filter_category", requirements={"token"= ".+"})
     */
    public function categoryFilter(string $token, string $category): Response
    {
        $catalog             = $this->catalogManager->findCatalogByUriOrFail($token);
        $selectedCategory    = $this->categoryManager->findCategoryByNameOrFail($category);
        $filters             = $this->catalogManager->getBasicFiltersByCatalog($catalog);
        $filters['category'] = $selectedCategory->getId();
        
        if ($this->request->isXmlHttpRequest()) {
            return $this->catalogManager->renderProducts($filters);
        }
        
        return $this->render('page/category-filtered-catalog.html.twig',
            array_merge(
                $this->getCatalogRenderParams($catalog, $filters),
                ['selectedCategory' => $selectedCategory]
            ));
    }
    
    /**
     * @Route("/{token}/", name="dynamic_pages",requirements={"token"= ".+"})
     */
    public function index($token)
    {
        if (!$page = $this->page_repository->findOneBy(['uri' => $token, 'published' => true])) {
            //Переадресовываем на раздел выше, если не была найдена страница
            $redirectUri = $this->getUriForRedirect($token);
            if (null !== $redirectUri) {
                return new RedirectResponse('/' . $redirectUri . '/');
            }
            throw new NotFoundHttpException();
        }
        
        if ($page instanceof Product) {
            return $this->product($page);
        }
        
        if ($page instanceof Catalog) {
            return $this->catalog($page);
        }
        
        if ($page instanceof Location) {
            return $this->location($page);
        }
        
        if ($page instanceof Markiz) {
            return $this->render('simple_catalog/markizyi/item.html.twig', [
                'page' => $page,
            ]);
        }
        
        if ($page instanceof Roll) {
            return $this->render('simple_catalog/item.html.twig', [
                'page' => $page,
            ]);
        }
        
        if ($page instanceof Roman) {
            return $this->render('simple_catalog/item.html.twig', [
                'page' => $page,
                'area' => true,
            ]);
        }
        
        if ($page instanceof Geo) {
            return $this->geo($page);
        }
        
        if ($page instanceof Calculator) {
            return $this->render('page/calculator.html.twig', [
                'page'              => $page,
                'type_filter'       => $page->getTypeFilter(),
                'selected_type'     => $page->getSelectedType(),
                'selected_material' => $page->getSelectedMaterial(),
            ]);
        }
        
        if ($page instanceof Article) {
            $page->incrementViews();
            $this->getDoctrine()->getManager()->flush();
            
            return $this->render('articles/item.html.twig', [
                'page' => $page,
            ]);
        }
        
        throw new NotFoundHttpException('Page is instance of ' . get_class($page));
    }
    
    private function product(Product $product): Response
    {
        $template = 'page/product.html.twig';
        if (strpos($product->getUri(), 'zhalyuzi') === 0) {
            $template = 'catalog/zhalyuzi/item.html.twig';
        }
        if (strpos($product->getUri(), 'rulonnyie-shtoryi') === 0) {
            $template = 'catalog/rulonnyie-shtoryi/item.html.twig';
        }
        $limit = 12;
        $items = $this->product_repository->getPopularSiblings($product, $limit);
        
        return $this->render($template, [
            'page'  => $product,
            'items' => $items,
        ]);
    }
    
    private function catalog(Catalog $catalog)
    {
        $filters            = $this->catalogManager->getBasicFiltersByCatalog($catalog);
        if ($this->request->isXmlHttpRequest()) {
            return $this->catalogManager->renderProducts($filters);
        }
    
        return $this->render($this->getCatalogTemplate($catalog),
            array_merge(
                $this->getCatalogRenderParams($catalog, $filters),
                [
                    'force_show_filters' => false,
                    'show_calc'          => true,
                    'selected_type'      => $catalog->getType()?->getId(),
                    'selected_material'  => $catalog->getMaterial()?->getId(),
                    'available_types'    => $catalog->getAvailableTypes(),
                ]
            ));
    }
    
    private function location(Location $location)
    {
        return $this->render('page/location.html.twig', [
            'page'  => $location,
            'items' => [],
        ]);
    }
    
    private function getCatalogRenderParams(Catalog $catalog, array $filters): array
    {
        return [
            'page'              => $catalog,
            'catalog'           => $catalog,
            'products'          => $this->catalogManager->getProductsPaginator($filters),
            'colors'            => $this->colorManager->getAvailableColors($filters),
            'categories'        => $this->categoryManager->getAllCategories(),
            'items'             => $this->catalogManager->getPopular($catalog),
            'catalogsLinks'     => $this->catalogManager->getCatalogsLinks($catalog),
            'selected_category' => $catalog->getSelectedCategory(),
            'filters'           => $filters,
        ];
    }
    
    private function geo(Geo $page): Response
    {
        $params = [
            'page'          => $page,
            'show_calc'     => true,
            'showCatalog'   => $page->isShowCatalog(),
            'lazyProducts'  => true,
            'selected_type' => $page->getGeoProductCalculatorSelectedType(),
        ];
        
        if ($params['showCatalog']) {
            $filters['type'] = $page->getTypeFilter();
            if ($this->request->query->get('products_only', false)) {
                return $this->catalogManager->renderProducts($filters);
            }
            $params['products'] = $this->catalogManager->getProductsPaginator($filters);
    
            /** @var Catalog $catalog */
            $catalog                 = $this->page_repository->findOneBy(['uri' => $page->getBaseCatalogUri()]);
            $params['catalog']       = $catalog;
            $params['catalogsLinks'] = $this->catalogManager->getCatalogsLinks($catalog);
            $params['colors']        = $this->colorManager->getAvailableColors($filters);
        }
    
        return $this->render('page/geo.html.twig', $params);
    }
    
    public function getUriForRedirect(string $requestedUri): ?string
    {
        $parts = explode('/', $requestedUri);
        if (count($parts) < 2) {
            return null;
        }
        array_pop($parts);
        $redirectUri = implode('/', $parts);
        if (null === $this->page_repository->findOneBy(['uri' => $redirectUri])) {
            return $this->getUriForRedirect($redirectUri);
        }
    
        return $redirectUri;
    }
    
    private function getCatalogTemplate(Catalog $catalog): string
    {
        $template = 'page/catalog.html.twig';
        if (str_starts_with($catalog->getUri(), 'zhalyuzi')) {
            $template = 'catalog/zhalyuzi/index.html.twig';
        }
        if (str_starts_with($catalog->getUri(), 'rulonnyie-shtoryi')) {
            $template = 'catalog/rulonnyie-shtoryi/index.html.twig';
        }
        
        return $template;
    }
}
