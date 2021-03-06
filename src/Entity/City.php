<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class City extends Geo
{
    public const TYPE = 'city';
    
    public function getH1(): string
    {
        return 'Жалюзи ' . $this->getName();
    }
    
    public function getTitle(): ?string
    {
        if (!empty($this->title)) {
            return $this->title;
        }
        
        return 'Жалюзи на окна купить ' . $this->getName();
    }
    
    public function getDescription(): ?string
    {
        if (!empty($this->description)) {
            return $this->description;
        }
    
        return sprintf('Жалюзи на окна купить недорого %s. ⭐ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ Жалюзи по низким ценам %s ☎ 8-800-775-72-38.',
            $this->getName(), $this->getName());
    }
}