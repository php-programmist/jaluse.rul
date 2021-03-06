<?php

namespace App\Entity;

use App\Entity\Contracts\GeoPageInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class District extends Page implements GeoPageInterface
{
    public const TYPE = 'district';
    
    public function getH1(): string
    {
        return 'Жалюзи в районе ' . $this->getName();
    }
    
    public function getTitle(): ?string
    {
        if (!empty($this->title)) {
            return $this->title;
        }
        
        return 'Жалюзи на окна купить в районе ' . $this->getName();
    }
    
    public function getCardHeader(): string
    {
        return $this->getH1() . ' цена';
    }
    
    public function getDescription(): ?string
    {
        if (!empty(parent::getDescription())) {
            return parent::getDescription();
        }
        
        return sprintf('Жалюзи на окна купить недорого в районе %s. ⭐ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ Жалюзи по низким ценам в районе %s ☎ 8-800-775-72-38.',
            $this->getName(), $this->getName());
    }
}