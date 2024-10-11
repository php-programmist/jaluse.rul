<?php

namespace App\Entity;

use App\Entity\Contracts\HasCatalogSettingsInterface;
use App\Entity\Traits\CatalogSettingsTrait;
use App\Model\Admin\LocationImport;
use App\Model\GeoProduct\RulonnyieShtoryiGeoProduct;
use App\Model\GeoProduct\ZhalyuziGeoProduct;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\EntityListeners({"App\EntityListener\LocationListener"})
 */
class Location extends Page implements HasCatalogSettingsInterface
{
    
    use CatalogSettingsTrait;
    
    public const TYPE = 'location';
    
    /**
     * @ORM\ManyToOne(targetEntity=Catalog::class, inversedBy="locations")
     */
    private ?Catalog $baseCatalog;
    
    public function getCardImgFolder()
    {
        return 'img/location/';
    }
    
    public function getType(): ?Type
    {
        $parent = $this->getParent();
        if ($parent && $parent instanceof Catalog) {
            return $parent->getType();
        }
        
        return null;
    }
    
    public function getDescription(): ?string
    {
        if (!empty(parent::getDescription())) {
            return parent::getDescription();
        }
        
        return sprintf('%s купить недорого в $city_prepositional. ✅ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в интернет магазине «Мастерская жалюзи» ☎ 8-800-775-72-38.',
            $this->getName(), $this->getName());
    }
    
    public function getTurboContentTemplate(): string
    {
        return 'turbo/locations/content.html.twig';
    }
    
    public function getGeoProductType(): string
    {
        return str_starts_with($this->getUri(), 'rulonnyie-shtoryi')
            ? RulonnyieShtoryiGeoProduct::TYPE
            : ZhalyuziGeoProduct::TYPE;
    }
    
    public function getPrice(): string
    {
        return $this->price;
    }
    
    public function setPrice(string $price)
    {
        $this->price = $price;
    }
    
    public function getCalcLink(): ?string
    {
        return '/' . $this->getBaseCatalogUri() . '/kalkulyator/';
    }
    
    public function getBaseCatalogUri(): string
    {
        return $this->getBaseCatalog()?->getUri();
    }
    
    public function getBaseCatalog(): ?Catalog
    {
        return $this->baseCatalog;
    }
    
    public function setBaseCatalog(?Catalog $baseCatalog): self
    {
        $this->baseCatalog = $baseCatalog;
        
        return $this;
    }
    
    public function generateDescription(): self
    {
        $this->description = sprintf('%s купить недорого в $city_prepositional. ⭐ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в интернет магазине «Мастерская жалюзи» ☎ 8-800-775-72-38.',
            $this->getH1(), $this->getName());
        
        return $this;
    }
    
    public function generateTitle(): self
    {
        $this->title = sprintf('%s купить в $city_prepositional с установкой. Каталог и цены', $this->getName());
        
        return $this;
    }
    
    public function generateCardDescription(LocationImport $locationImport, string $locationName): self
    {
        $this->cardDescription = sprintf(
            '<p><span><b>Материал:</b> %s</span> <span><b>Цвет:</b> на выбор.</span> <span><b>Размеры:</b> стандартные и под заказ</span> <span><b>Тип:</b> %s</span> <span><b>Виды:</b> %s</span> <span><b>Помещения:</b> %s</span><span><b>Управление:</b> механическое и автоматическое</span> <span><b>Срок изготовления и установки:</b> 2-7 дней (зависит от сложности и объема).</span> <span><b>Замер:</b> бесплатный (при оформлении и оплате заказа).</span> <span><b>Доставка и установка жалюзи:</b> в $city_and_region_prepositional.</span> <span>Возможна доставка и установка по России</span></p>
',
            $locationImport->getMaterials(),
            $locationImport->getType(),
            $locationImport->getSubTypes(),
            $locationName
        );
    
        return $this;
    }
    
    public function getShortName(): string
    {
        return $this->name;
    }
}
