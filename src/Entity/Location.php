<?php

namespace App\Entity;

use App\Model\GeoProduct\RulonnyieShtoryiGeoProduct;
use App\Model\GeoProduct\ZhalyuziGeoProduct;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\EntityListeners({"App\EntityListener\LocationListener"})
 */
class Location extends Page
{
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
        
        return sprintf('%s купить недорого в Москве. ✅ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в интернет магазине «Мастерская жалюзи» ☎ 8-800-775-72-38.',
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
}
