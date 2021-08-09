<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class District extends Geo
{
    public const TYPE = 'district';
    
    public function getH1(): string
    {
        return $this->getGeoProduct()->getNameNominative() . ' в районе ' . $this->getName();
    }
    
    public function getTitle(): ?string
    {
        if (!empty($this->title)) {
            return $this->title;
        }
        
        return $this->getGeoProduct()->getNameNominative() . ' на окна купить в районе ' . $this->getName() . ' | Каталог и цены';
    }
    
    public function getDescription(): ?string
    {
        if (!empty($this->description)) {
            return $this->description;
        }
        
        return sprintf('%s на окна купить недорого в районе %s. ⭐ Выезд и замер бесплатно! ✅ Изготовление %s с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в районе %s ☎ 8-800-775-72-38.',
            $this->getGeoProduct()->getNameNominative(),
            $this->getName(),
            $this->getGeoProduct()->getNameGenitive(),
            $this->getGeoProduct()->getNameNominative(),
            $this->getName());
    }
    
    /**
     * @return Collection|Metro[]
     */
    public function getMetros(): Collection
    {
        return $this->getPages()->filter(function (Page $page) {
            return $page instanceof Metro;
        });
    }
    
    /**
     * @return Collection|District[]
     */
    public function getSubDistricts(): Collection
    {
        return $this->getPages()->filter(function (Page $page) {
            return $page instanceof District;
        });
    }
    
    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->getPages()->filter(function (Page $page) {
            return $page instanceof City;
        });
    }
    
}