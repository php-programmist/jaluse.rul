<?php

namespace App\Model\GeoProduct;

use LogicException;

abstract class AbstractGeoProduct
{
    private const MAP = [
        ZhalyuziGeoProduct::TYPE         => ZhalyuziGeoProduct::class,
        RulonnyieShtoryiGeoProduct::TYPE => RulonnyieShtoryiGeoProduct::class,
    ];
    /**
     *
     * @var string
     */
    protected $nameNominative;
    
    /**
     * @var string
     */
    protected $nameGenitive;
    
    /**
     * @var string
     */
    protected $cardImage;
    
    /**
     * @var string
     */
    protected $price;
    
    /**
     * @return string
     */
    public function getNameNominative(): string
    {
        return $this->nameNominative;
    }
    
    /**
     * @return string
     */
    public function getNameGenitive(): string
    {
        return $this->nameGenitive;
    }
    
    /**
     * @return string
     */
    public function getCardImage(): string
    {
        return $this->cardImage;
    }
    
    public static function create(string $type): AbstractGeoProduct
    {
        $class = self::MAP[$type] ?? null;
        if (null === $class) {
            throw new LogicException(sprintf('%s - неверный тип наследника класса AbstractGeoProduct', $type));
        }
        
        return new $class();
    }
    
    public function getPrice(): string
    {
        return $this->price;
    }
    
}