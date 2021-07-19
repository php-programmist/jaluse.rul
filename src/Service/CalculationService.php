<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class CalculationService
{
    
    protected float $usd_rate;
    protected MatrixService $matrix_service;
    private array $matrices = [];
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;
    
    public function __construct(
        ConfigService $config_service,
        MatrixService $matrix_service,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->matrix_service = $matrix_service;
        $this->usd_rate       = $config_service->getCached('calc.usd_rate');
        $this->entityManager  = $entityManager;
        $this->logger         = $logger;
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
    
    public function getRubPrice(float $usdPrice): int
    {
        return round($this->usd_rate * $usdPrice);
    }
    
    public function getCatalogMinPriceByUri(string $catalogUri): int
    {
        /** @var Catalog $catalog */
        $catalog = $this->entityManager->getRepository(Catalog::class)->findOneBy(['uri' => $catalogUri]);
        if (null === $catalog) {
            $this->logger->error('Не найден каталог - ' . $catalogUri);
            
            return 0;
        }
        
        $minPrice = $this->getCatalogMinPrice($catalog);
        
        if (0 === $minPrice) {
            $this->logger->error(sprintf('Для каталога %s не удалось рассчитать минимальную цену', $catalogUri));
        }
        
        return $minPrice;
    }
    
    private function getCatalogMinPrice(Catalog $catalog): int
    {
        $minPrice = 0;
        if (null === $catalog->getType()) {
            $this->logger->error(sprintf('У каталога %s отсутствует тип', $catalog->getUri()));
            
            return 0;
        }
        
        foreach ($catalog->getPages() as $page) {
            $minPriceCandidate = 0;
            
            if ($page instanceof Product) {
                $minPriceCandidate = $this->getMinPrice($page);
            } elseif ($page instanceof Catalog) {
                $minPriceCandidate = $this->getCatalogMinPrice($page);
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
}