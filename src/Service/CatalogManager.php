<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Contracts\HasCatalogSettingsInterface;
use App\Entity\Product;
use App\Entity\Type;
use App\Repository\CatalogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class CatalogManager
{
    private EntityManagerInterface $entityManager;
    private PaginatorInterface $paginator;
    private ?Request $request;
    private CatalogRepository $catalogRepository;
    
    /**
     * @param EntityManagerInterface $entityManager
     * @param RequestStack           $requestStack
     * @param PaginatorInterface     $paginator
     * @param CatalogRepository      $catalogRepository
     * @param ConfigService          $configs
     * @param Environment            $twig
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        PaginatorInterface $paginator,
        CatalogRepository $catalogRepository,
        private ConfigService $configs,
        private Environment $twig,
        private DeviceManager $deviceManager,
    ) {
        $this->entityManager = $entityManager;
        
        $this->paginator         = $paginator;
        $this->request           = $requestStack->getCurrentRequest();
        $this->catalogRepository = $catalogRepository;
    }
    
    /**
     * @param Catalog $catalog
     * @param int     $limit
     *
     * @return Product[]|array
     */
    public function getPopular(Catalog $catalog, int $limit = 0): array
    {
        $filters             = $this->getBasicFiltersByCatalog($catalog);
        $filters['category'] = 1;
    
        return $this->entityManager
            ->getRepository(Product::class)
            ->getPopular($filters, $limit);
    }
    
    /**
     * @param array  $filters
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return Query
     */
    public function getProductsQuery(array $filters, string $orderBy, string $orderDir): Query
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->getProductsQB($filters, $orderBy, $orderDir)
            ->getQuery();
    }
    
    public function getBasicFiltersByCatalog(Catalog $catalog): array
    {
        $filters = $catalog->getFilters();
    
        if ($filters['exact_catalog'] ?? false) {
            $filters['parent'] = $catalog->getId();
        } else {
            if (empty($filters['type']) && $catalog->getType()) {
                $filters['type'] = $catalog->getType()->getId();
            }
        
            if ($catalog->getMaterial()) {
                $filters['material'] = $catalog->getMaterial()->getId();
            }
        
            $filters['excluded_materials'] = implode(',', $catalog->getExcludedMaterials());
        }
    
        return $filters;
    }
    
    public function getCatalogsLinks(Catalog $catalog): array
    {
        if ($catalog->isPremium()) {
            //Не показываем ссылки для страниц премиум-каталогов
            return [];
        }
    
        if (!empty($catalog->getCatalogLinks())) {
            return $catalog->getCatalogLinks();
        }
    
        $type     = $catalog->getType();
        $material = $catalog->getMaterial();
        $allTypes = $this->entityManager->getRepository(Type::class)->findBy([], ['id' => 'asc']);
        $links    = [];
        if (null === $material) {
            //Один из каталогов верхнего уровня.
            if (null === $type || $type->getMaterials()->isEmpty()) {
                //Подтипы отсутствуют - показываем соседние каталоги с типами
                /** @var Type $type */
                foreach ($allTypes as $type) {
                    if (!$type->getCatalogs()->isEmpty()) {
                        foreach ($type->getCatalogs() as $siblingCatalog) {
                            if (null === $siblingCatalog->getMaterial()) {
                                $links[$type->getName()] = $siblingCatalog->getPath();
                            }
                        }
                    }
                }
            } else {
                //Есть подтипы - показываем каталоги подтипов
                $links = $this->getMaterialLinks($type, $catalog, $links);
            }
            
        } else {
            //Это подтип
            $links = $this->getMaterialLinks($type, $catalog, $links);
            
        }
        
        return $links;
    }
    
    /**
     * @param Type    $type
     * @param Catalog $catalog
     * @param array   $links
     *
     * @return array
     */
    private function getMaterialLinks(Type $type, Catalog $catalog, array $links): array
    {
        foreach ($type->getMaterials() as $siblingMaterial) {
            $catalogs = $siblingMaterial->getCatalogs();
            if (count($catalogs) > 1 && null !== $catalog->getType()) {
                foreach ($catalogs as $siblingCatalog) {
                    if ($catalog->getType()->getId() === $type->getId()) {
                        $links[$siblingMaterial->getName()] = $siblingCatalog->getPath();
                    }
                }
            } else {
                $links[$siblingMaterial->getName()] = $siblingMaterial->getCatalogs()->first()->getPath();
            }
    
        }
    
        return $links;
    }
    
    /**
     * @param array                       $filters
     * @param HasCatalogSettingsInterface $catalog
     * @param int|null                    $limit
     *
     * @return PaginationInterface
     */
    public function getProductsPaginator(
        array $filters,
        HasCatalogSettingsInterface $catalog,
        ?int $limit = null
    ): PaginationInterface {
        $order      = $this->request->query->get('order', $catalog->getDefaultOrdering());
        $orderParts = explode('-', $order);
        $orderBy    = $orderParts[0];
        $orderDir   = $orderParts[1] ?? 'asc';
        
        $defaultLimitName = $this->deviceManager->isMobile()
            ? 'calc.products_catalog_limit_mobile'
            : 'calc.products_catalog_limit';
        
        $pagination = $this->paginator->paginate(
            $this->getProductsQuery($filters, $orderBy, $orderDir),
            $this->request->query->getInt('page', 1),
            $catalog->getProductsPerPage() ?? $limit ?? $this->configs->getCached($defaultLimitName)
        );
        $pagination->setParam('_fragment', 'content');
        
        return $pagination;
    }
    
    public function findCatalogByUriOrFail(string $uri): Catalog
    {
        if (!$catalog = $this->catalogRepository->findOneBy(['uri' => $uri])) {
            throw new NotFoundHttpException();
        }
        
        return $catalog;
    }
    
    public function renderProducts(array $filters, HasCatalogSettingsInterface $catalog): Response
    {
        $html = $this->twig->render('catalog/blocks/products.html.twig', [
            'products' => $this->getProductsPaginator($filters, $catalog),
            'lazy_off' => true,
        ]);
        
        return (new Response())->setContent($html);
    }
}