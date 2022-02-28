<?php

namespace App\Entity;

use App\Model\GeoProduct\AbstractGeoProduct;
use App\Model\GeoProduct\RulonnyieShtoryiGeoProduct;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"App\EntityListener\GeoListener"})
 */
abstract class Geo extends Page
{
    public const TYPE = 'geo';
    /**
     * @var AbstractGeoProduct
     */
    protected $geoProduct;
    
    /**
     * @return AbstractGeoProduct
     */
    public function getGeoProduct(): AbstractGeoProduct
    {
        if (null === $this->geoProduct) {
            $this->geoProduct = AbstractGeoProduct::create($this->getGeoProductType());
        }
        
        return $this->geoProduct;
    }
    
    public function getCardHeader(): string
    {
        return $this->getH1() . ' цена';
    }
    
    public function getCardDescription(): string
    {
        return sprintf('<p><span><b>Материал:</b> ткань, алюминий, пластик, дерево.</span> <span><b>Цвет:</b> на выбор.</span> <span><b>Размеры:</b> стандартные и под заказ</span> <span><b>Тип:</b> горизонтальные и вертикальные.</span> <span><b>Виды:</b> алюминиевые, пластиковые, деревянные, тканевые.</span> <span><b>Помещения:</b>&nbsp;терраса&nbsp;</span><span><b>Управление:</b> механическое и автоматическое</span> <span><b>Срок изготовления и установки:</b> 2-7 дней (зависит от сложности и объема).</span> <span><b>Замер:</b> бесплатный (при оформлении и оплате заказа).</span> <span><b>Доставка и установка %s:</b> в Москве и Московской области.</span> <span>Возможна доставка и установка по России</span></p>',
            $this->getGeoProduct()->getNameGenitive());
    }
    
    public function getCardImageUrl(): string
    {
        return $this->getGeoProduct()->getCardImage();
    }
    
    public function getTypeFilter(): string
    {
        return $this->getGeoProductType() === RulonnyieShtoryiGeoProduct::TYPE ? '133' : '86,132,178';
    }
    
    public function isShowCatalog(): bool
    {
        return $this instanceof City
               || in_array($this->getUri(), ['moskovskoy-oblasti', 'rulonnyie-shtoryi/moskovskoy-oblasti']);
    }
    
    public function getBaseCatalogUri(): string
    {
        return $this->getGeoProductType() === RulonnyieShtoryiGeoProduct::TYPE ? 'rulonnyie-shtoryi' : 'zhalyuzi/vertikalnye';
    }
    
    public function getPriceFormat(): string
    {
        return $this->getGeoProductType() === RulonnyieShtoryiGeoProduct::TYPE ? 'от %d рублей за изделие' : 'от %d руб/м2';
    }
}