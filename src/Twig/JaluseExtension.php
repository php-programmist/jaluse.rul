<?php

namespace App\Twig;

use App\Entity\Product;
use App\Service\CalculationService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class JaluseExtension extends AbstractExtension
{
    /**
     * @var CalculationService
     */
    protected $calculation_service;
    
    public function __construct(CalculationService $calculation_service)
    {
        $this->calculation_service = $calculation_service;
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('min_price', [$this, 'min_price'], ['is_safe' => ['html']]),
            new TwigFunction('rub_price', [$this, 'rub_price']),
        ];
    }

    public function min_price(Product $product, bool $digitsOnly = false)
    {
        $min_price = $this->calculation_service->getMinPrice($product);
        if ($digitsOnly){
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
    
    public function rub_price(float $usdPrice): int
    {
        return $this->calculation_service->getRubPrice($usdPrice);
    }
}
