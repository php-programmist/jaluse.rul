<?php

namespace App\Entity;

use App\Model\GeoProduct\ZhalyuziGeoProduct;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Metro extends Geo
{
    public const TYPE = 'metro';
    
    /**
     * @var string
     * @ORM\Column(type="string",options={"default": App\Model\GeoProduct\ZhalyuziGeoProduct::TYPE})
     */
    protected $geoProductType = ZhalyuziGeoProduct::TYPE;
    
    public function getH1(): string
    {
        return $this->getGeoProduct()->getNameNominative() . ' в районе метро ' . $this->getName();
    }
    
    public function getTitle(): ?string
    {
        if (!empty($this->title)) {
            return $this->title;
        }
        
        return $this->getGeoProduct()->getNameNominative() . ' на окна 🚩 метро ' . $this->getName();
    }
    
    public function getDescription(): ?string
    {
        if (!empty($this->description)) {
            return $this->description;
        }
        
        return sprintf('%s на окна купить недорого около метро %s. ⭐ Выезд и замер бесплатно! ✅ Изготовление %s с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в районе метро %s ☎ 8-800-775-72-38.',
            $this->getGeoProduct()->getNameNominative(),
            $this->getName(),
            $this->getGeoProduct()->getNameGenitive(),
            $this->getGeoProduct()->getNameNominative(),
            $this->getName());
    }
}