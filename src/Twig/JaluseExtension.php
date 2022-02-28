<?php

namespace App\Twig;

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
    
    public function catalog_min_price(string $catalogUri): int
    {
        $key  = sprintf('catalog_min_price.%s', str_replace('/', '_', $catalogUri));
        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            $value = $this->calculation_service->getCatalogMinPriceByUri($catalogUri);
            $item->set($value);
            $this->cache->save($item);
    
        }
        
        return $item->get();
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
}
