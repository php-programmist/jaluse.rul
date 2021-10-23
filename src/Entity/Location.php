<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location extends Page
{
    public const TYPE = 'location';
    
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
    
    public function getPrice(): string
    {
        if (strpos($this->getUri(), 'rulonnyie-shtoryi') === 0) {
            return 'от 1432 рублей за изделие';
        }
        
        return 'от 664 руб/м2';
    }
    
    public function getCalcLink(): ?string
    {
        return str_contains($this->getUri(), 'rulonnyie-shtoryi')
            ? '/rulonnyie-shtoryi/kalkulyator/'
            : '/zhalyuzi/kalkulyator/';
    }
}
