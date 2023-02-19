<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Geo;
use App\Entity\Markiz;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\Roll;
use App\Entity\Roman;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CalculationService
{
    
    protected float $usd_rate;
    private array $matrices = [];
    private int $discountGlobal;
    
    public function __construct(
        ConfigService $config_service,
        private MatrixService $matrix_service,
        private CatalogManager $catalogManager,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    ) {
        $this->usd_rate       = $config_service->getCached('calc.usd_rate');
        $this->discountGlobal = $config_service->getCached('calc.discount_global');
        /*$this->entityManager
            ->getConnection()
            ->getConfiguration()
            ?->setSQLLogger();*/
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
        try{
            $catalog = $this->findCatalogByUri($catalogUri);
        } catch (Throwable){
            return 0;
        }
        $minPrice = $this->getCatalogMinPrice($catalog, $filters);
    
        if (0 === $minPrice) {
            $this->logger->error(sprintf('Для каталога %s не удалось рассчитать минимальную цену', $catalogUri));
        }
    
        return $minPrice;
    }
    
    public function getCatalogMaxPriceByUri(string $catalogUri, array $filters = []): int
    {
        if (in_array($catalogUri, ['zhalyuzi', 'zhalyuzi/premium-klassa'])) {
            $catalogUri = 'vertikalnye-zhalyuzi-na-okna';
        }
        try{
            $catalog = $this->findCatalogByUri($catalogUri);
        } catch (Throwable){
            return 0;
        }
        $maxPrice = $this->getCatalogMaxPrice($catalog, $filters);
    
        if (0 === $maxPrice) {
            $this->logger->error(sprintf('Для каталога %s не удалось рассчитать максимальную цену', $catalogUri));
        }
    
        return $maxPrice;
    }
    
    public function getCatalogProductsCount(string $catalogUri, array $filters = []): int
    {
        try{
            $catalog = $this->findCatalogByUri($catalogUri);
        } catch (Throwable){
            return 0;
        }
    
        $count = $this->getCatalogProductsNumber($catalog, $filters);
    
        if (0 === $count) {
            $this->logger->error(sprintf('Для каталога %s не удалось посчитать количество товаров', $catalogUri));
        }
    
        return $count;
    }
    
    private function findCatalogByUri(string $catalogUri): Catalog
    {
        $catalog = $this->entityManager->getRepository(Page::class)->findOneBy(['uri' => $catalogUri]);
        if ($catalog instanceof Geo) {
            return $this->findCatalogByUri($catalog->getBaseCatalogUri());
        }
    
        if (!($catalog instanceof Catalog)) {
            throw new NotFoundHttpException('Не найден каталог - ' . $catalogUri);
        }
    
        if (null !== $catalog->getSeoType()) {
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
    
        if ($catalog->isAggregateCatalog()) {
            return $this->getCatalogMinPriceByFilters($catalog, $filters);
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
        if ($catalog->isAggregateCatalog()) {
            return $this->getCatalogMaxPriceByFilters($catalog, $filters);
        }
    
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
        if ($catalog->isAggregateCatalog()) {
            return $this->getCatalogProductsNumberByFilters($catalog, $filters);
        }
    
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
    
    public function getChildCatalogWithSeoType(Catalog $catalog, string $seoType): ?Catalog
    {
        return $this->entityManager
            ->getRepository(Catalog::class)
            ->findOneBy(['parent' => $catalog, 'seoType' => $seoType]);
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
    
    private function getCatalogMinPriceByFilters(Catalog $catalog, array $filters): int
    {
        if (empty($filters)) {
            $filters = $this->catalogManager->getBasicFiltersByCatalog($catalog);
        }
        $products = $this->getProductsByFilters($filters);
        $minPrice = 0;
        foreach ($products as $product) {
            $price = $this->getMinPrice($product);
            if ($price > 0 && ($price < $minPrice || 0 === $minPrice)) {
                $minPrice = $price;
            }
        }
        
        return $minPrice;
    }
    
    private function getCatalogMaxPriceByFilters(Catalog $catalog, array $filters): int
    {
        if (empty($filters)) {
            $filters = $this->catalogManager->getBasicFiltersByCatalog($catalog);
        }
        $products = $this->getProductsByFilters($filters);
        $maxPrice = 0;
        foreach ($products as $product) {
            $price = $this->getMinPrice($product);
            if ($price > $maxPrice) {
                $maxPrice = $price;
            }
        }
        
        return $maxPrice;
    }
    
    private function getCatalogProductsNumberByFilters(Catalog $catalog, array $filters): int
    {
        if (empty($filters)) {
            $filters = $this->catalogManager->getBasicFiltersByCatalog($catalog);
        }
        
        return $this->entityManager
            ->getRepository(Product::class)
            ->getProductsQB($filters, 'price', 'desc')
            ->select('count(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    /**
     * @param array $filters
     *
     * @return Product[]
     */
    private function getProductsByFilters(array $filters): iterable
    {
        return $this->catalogManager
            ->getProductsQuery($filters, 'price', 'desc')
            ->toIterable();
    }
}