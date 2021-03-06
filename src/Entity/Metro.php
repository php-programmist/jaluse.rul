<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Metro extends Geo
{
    public const TYPE = 'metro';
    
    public function getH1(): string
    {
        return 'Жалюзи в районе метро ' . $this->getName();
    }
    
    public function getTitle(): ?string
    {
        if (!empty($this->title)) {
            return $this->title;
        }
        
        return 'Жалюзи на окна 🚩 метро ' . $this->getName();
    }
    
    public function getDescription(): ?string
    {
        if (!empty($this->description)) {
            return $this->description;
        }
    
        return sprintf('Жалюзи на окна купить недорого около метро %s. ⭐ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ Жалюзи по низким ценам в районе метро %s ☎ 8-800-775-72-38.',
            $this->getName(), $this->getName());
    }
}