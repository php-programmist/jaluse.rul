<?php

namespace App\Twig;

use App\Entity\Catalog;
use App\Entity\Page;
use App\Entity\Product;
use App\Service\CalculationService;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class JaluseExtension extends AbstractExtension
{
    protected CalculationService $calculation_service;
    private AdapterInterface $cache;
    
    public function __construct(CalculationService $calculation_service, AdapterInterface $cache)
    {
        $this->calculation_service = $calculation_service;
        $this->cache               = $cache;
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('min_price', [$this, 'min_price'], ['is_safe' => ['html']]),
            new TwigFunction('rub_price', [$this, 'rub_price']),
            new TwigFunction('catalog_min_price', [$this, 'catalog_min_price']),
            new TwigFunction('discounted_price', [$this, 'discounted_price']),
            new TwigFunction('price_with_delivery', [$this, 'price_with_delivery']),
            new TwigFunction('catalog_max_price', [$this, 'catalog_max_price']),
            new TwigFunction('catalog_products_count', [$this, 'catalog_products_count']),
            new TwigFunction('premium_link', [$this, 'getPremiumLink'], ['is_safe' => ['html']]),
        ];
    }
    
    public function min_price(Product $product, bool $digitsOnly = false, bool $discounted = false)
    {
        $min_price = $discounted
            ? $this->calculation_service->getMinDiscountedPrice($product)
            : $this->calculation_service->getMinPrice($product);
        
        if ($digitsOnly) {
            return $min_price;
        }
        if (!$min_price || !$product->getType()) {
            return 'рассчитывается индивидуально';
        }
        if ($product->getType()->getCalculationType() === 'simple') {
            return sprintf('<span class="price">%s</span> <small>руб. за м<sup>2</sup></small>', $min_price);
        }
        
        return sprintf('от <span class="price">%s</span> <small>руб. за изделие</small>', $min_price);
    }
    
    public function catalog_min_price(string $catalogUri, array $filters = []): int
    {
        $key = $this->getCacheKey('catalog_min_price', $catalogUri, $filters);
        
        return $this->getCachedValue(
            $key,
            fn() => $this->calculation_service->getCatalogMinPriceByUri($catalogUri, $filters)
        );
    }
    
    public function catalog_max_price(string $catalogUri, array $filters = []): int
    {
        $key = $this->getCacheKey('catalog_max_price', $catalogUri, $filters);
        
        return $this->getCachedValue(
            $key,
            fn() => $this->calculation_service->getCatalogMaxPriceByUri($catalogUri, $filters)
        );
    }
    
    public function catalog_products_count(string $catalogUri, array $filters = []): int
    {
        $key = $this->getCacheKey('catalog_products_count', $catalogUri, $filters);
        
        return $this->getCachedValue(
            $key,
            fn() => $this->calculation_service->getCatalogProductsCount($catalogUri, $filters)
        );
    }
    
    public function discounted_price(int $basePrice, int $discount = 7): int
    {
        return $this->calculation_service->getDiscountedPrice($basePrice, $discount);
    }
    
    public function price_with_delivery(int $basePrice, int $discount = 7, int $deliveryCost = 500): int
    {
        return $this->discounted_price($basePrice, $discount) + $deliveryCost;
    }
    
    public function rub_price(float $usdPrice): int
    {
        return $this->calculation_service->getRubPrice($usdPrice);
    }
    
    public function getPremiumLink(?Page $page): string
    {
        if (!($page instanceof Catalog)) {
            return '';
        }
        $premiumCatalog = $this->calculation_service->getPremiumCatalog($page);
        if (null === $premiumCatalog) {
            return '';
        }
        
        return sprintf('<a href="%s#content" class="footer-nav-ssli">Премиум класса</a>', $premiumCatalog->getPath());
    }
    
    private function getCacheKey(string $nameSpace, string $catalogUri, array $filters): string
    {
        $key = sprintf('%s.%s', $nameSpace, str_replace('/', '_', $catalogUri));
        foreach ($filters as $name => $value) {
            $key .= sprintf('.%s.%s', $name, $value);
        }
    
        return $key;
    }
    
    private function getCachedValue(string $key, callable $getValue): int
    {
        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            $value = $getValue();
            $item->set($value);
            $this->cache->save($item);
        }
        
        return $item->get();
    }
}
