<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Markiz;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\Roll;
use App\Entity\Roman;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CalculationService
{
    
    protected float $usd_rate;
    protected MatrixService $matrix_service;
    private array $matrices = [];
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;
    private int $discountGlobal;
    
    public function __construct(
        ConfigService $config_service,
        MatrixService $matrix_service,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->matrix_service = $matrix_service;
        $this->usd_rate       = $config_service->getCached('calc.usd_rate');
        $this->discountGlobal = $config_service->getCached('calc.discount_global');
        $this->entityManager  = $entityManager;
        $this->logger         = $logger;
    }
    
    public function getMinDiscountedPrice(Product $product): int
    {
        return $this->getDiscountedPrice(
            $this->getMinPrice($product),
            $product->getDiscount() ? : null
        );
    }
    
    public function getMinPrice(Product $product): int
    {
        $type = $product->getType();
        if (!$type) {
            return 0;
        }
        if ($product->getPrice() && $type->getCalculationType() === 'simple') {
            return $this->getRubPrice($product->getPrice());
        }
        if ($type->getCalculationType() === 'matrix') {
            if (empty($this->matrices)) {
                $this->matrices = $this->matrix_service->getAllCachedMatrices();
            }
            if (!isset($this->matrices[$product->getMatrixFolder()][$product->getMatrixId()])) {
                return 0;
            }
            $matrix    = $this->matrices[$product->getMatrixFolder()][$product->getMatrixId()];
            $min_width = current($matrix);
            $min_price = current($min_width);
            
            return $this->getRubPrice($min_price);
        }
        
        return 0;
    }
    
    /**
     * @param Product[] $products
     */
    public function setMinPriceForAll(array $products)
    {
        foreach ($products as $product) {
            $product->setMinPrice($this->getMinPrice($product));
        }
    }
    
    public function getRubPrice(?float $usdPrice): int
    {
        if (null === $usdPrice) {
            return 0;
        }
    
        return round($this->usd_rate * $usdPrice);
    }
    
    public function getCatalogMinPriceByUri(string $catalogUri, array $filters = []): int
    {
        if (in_array($catalogUri, ['zhalyuzi', 'zhalyuzi/premium-klassa'])) {
            $catalogUri = 'zhalyuzi/gorizontalnye';
        }
        $catalog = $this->findCatalogByUri($catalogUri);
        
        $minPrice = $this->getCatalogMinPrice($catalog, $filters);
        
        if (0 === $minPrice) {
            $this->logger->error(sprintf('Для каталога %s не удалось рассчитать минимальную цену', $catalogUri));
        }
        
        return $minPrice;
    }
    
    public function getCatalogMaxPriceByUri(string $catalogUri, array $filters = []): int
    {
        if (in_array($catalogUri, ['zhalyuzi', 'zhalyuzi/premium-klassa'])) {
            $catalogUri = 'zhalyuzi/vertikalnye';
        }
        $catalog = $this->findCatalogByUri($catalogUri);
        
        $maxPrice = $this->getCatalogMaxPrice($catalog, $filters);
        
        if (0 === $maxPrice) {
            $this->logger->error(sprintf('Для каталога %s не удалось рассчитать максимальную цену', $catalogUri));
        }
        
        return $maxPrice;
    }
    
    public function getCatalogProductsCount(string $catalogUri, array $filters = []): int
    {
        $catalog = $this->findCatalogByUri($catalogUri);
        
        $count = $this->getCatalogProductsNumber($catalog, $filters);
        
        if (0 === $count) {
            $this->logger->error(sprintf('Для каталога %s не удалось посчитать количество товаров', $catalogUri));
        }
        
        return $count;
    }
    
    private function findCatalogByUri(string $catalogUri): Catalog
    {
        $catalog = $this->entityManager->getRepository(Catalog::class)->findOneBy(['uri' => $catalogUri]);
        if (!($catalog instanceof Catalog)) {
            throw new NotFoundHttpException('Не найден каталог - ' . $catalogUri);
        }
    
        if ($catalog->isPremium() || $catalog->isNoDrill()) {
            $catalog = $catalog->getParent();
        }
    
        return $catalog;
    }
    
    private function getCatalogMinPrice(Catalog $catalog, array $filters): int
    {
        $minPrice = 0;
        if (null !== $catalog->getPrice()) {
            return $catalog->getPrice();
        }
        
        foreach ($catalog->getPages() as $page) {
            $minPriceCandidate = 0;
            if (!$page->getPublished()) {
                continue;
            }
            if ($page instanceof Product && $this->isSatisfyFilters($page, $filters)) {
                $minPriceCandidate = $this->getMinPrice($page);
            } elseif ($page instanceof Catalog) {
                $minPriceCandidate = $this->getCatalogMinPrice($page, $filters);
            } elseif ($page instanceof Markiz || $page instanceof Roll || $page instanceof Roman) {
                $minPriceCandidate = $page->getPrice();
            }
            
            if (
                $minPriceCandidate > 0
                && ($minPriceCandidate < $minPrice || 0 === $minPrice)
            ) {
                $minPrice = $minPriceCandidate;
            }
        }
        
        return $minPrice;
    }
    
    private function getCatalogMaxPrice(Catalog $catalog, array $filters): int
    {
        $maxPrice = 0;
        foreach ($catalog->getPages() as $page) {
            $maxPriceCandidate = 0;
            if (!$page->getPublished()) {
                continue;
            }
            if ($page instanceof Product && $this->isSatisfyFilters($page, $filters)) {
                $maxPriceCandidate = $this->getMinPrice($page);
            } elseif ($page instanceof Catalog) {
                $maxPriceCandidate = $this->getCatalogMaxPrice($page, $filters);
            } elseif ($page instanceof Markiz || $page instanceof Roll || $page instanceof Roman) {
                $maxPriceCandidate = $page->getPrice();
            }
            
            if ($maxPriceCandidate > 0 && $maxPriceCandidate > $maxPrice) {
                $maxPrice = $maxPriceCandidate;
            }
        }
        
        return $maxPrice;
    }
    
    private function getCatalogProductsNumber(Catalog $catalog, array $filters): int
    {
        $filterCallable = fn(Page $page) => $page instanceof Product
                                            && $page->getPublished()
                                            && $this->getMinPrice($page) > 0
                                            && $this->isSatisfyFilters($page, $filters);
        
        $products = $catalog->getPages()->filter($filterCallable);
        $count    = $products ? $products->count() : 0;
        
        $markiz = $catalog->getPages()->filter(fn(Page $page) => $page instanceof Markiz
                                                                 && $page->getPublished()
        );
        $count  += $markiz ? $markiz->count() : 0;
        
        $subCatalogs = $catalog->getPages()->filter(fn(Page $page
        ) => $page instanceof Catalog && $page->getPublished());
        if ($subCatalogs) {
            foreach ($subCatalogs as $subCatalog) {
                $count += $this->getCatalogProductsNumber($subCatalog, $filters);
            }
        }
        
        return $count;
    }
    
    /**
     * @param Product[] $products
     *
     * @return Product[]
     */
    public function setRubPriceForProducts(array $products): array
    {
        return array_map(
            fn(Product $product) => $this->setRubPriceForProduct($product),
            $products
        );
    }
    
    public function setRubPriceForProduct(Product $product): Product
    {
        return $product->setPrice($this->getRubPrice($product->getPrice()));
    }
    
    public function getDiscountedPrice(float $basePrice, ?int $discount = null): int
    {
        $discount ??= $this->discountGlobal;
    
        return round($basePrice * (1 - $discount / 100));
    }
    
    public function getPremiumCatalog(Catalog $catalog): ?Catalog
    {
        return $this->entityManager
            ->getRepository(Catalog::class)
            ->findOneBy(['parent' => $catalog, 'premium' => true]);
    }
    
    public function getNoDrillCatalog(Catalog $catalog): ?Catalog
    {
        return $this->entityManager
            ->getRepository(Catalog::class)
            ->findOneBy(['parent' => $catalog, 'noDrill' => true]);
    }
    
    private function isSatisfyFilters(Product $product, array $filters): bool
    {
        if (empty($filters)) {
            return true;
        }
        
        foreach ($filters as $field => $value) {
            switch ($field) {
                case 'category':
                    $categories = explode(',', $value);
                    if (!in_array($product->getCategory()?->getId(), $categories, false)) {
                        return false;
                    }
                    break;
                case 'color':
                    if ($product->getColorId() !== $value) {
                        return false;
                    }
                    break;
            }
        }
        
        return true;
    }
}