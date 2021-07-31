<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Calculator extends Page
{
    public const TYPE = 'calculator';
    
    public function getTypeFilter(): array
    {
        $types = [];
        if (str_contains($this->getUri(), 'zhalyuzi')) {
            $types = [86, 132, 178];
        } elseif (str_contains($this->getUri(), 'rulonnyie-shtoryi')) {
            $types = [133, 175];
        }
        
        return $types;
    }
    
    public function getSelectedType(): int
    {
        $type   = 0;
        $parent = $this->getParent();
        if ($parent instanceof Catalog) {
            $type = $parent->getType()?->getId() ?? 0;
        }
        
        return $type;
    }
    
    public function getSelectedMaterial(): int
    {
        $type   = 0;
        $parent = $this->getParent();
        if ($parent instanceof Catalog) {
            $type = $parent->getMaterial()?->getId() ?? 0;
        }
        
        return $type;
    }
    
    public function getDescriptionComputed(): string
    {
        if (!empty($this->getDescription())) {
            return $this->getDescription();
        }
        
        return sprintf('%s.⭐ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐  Расчет жалюзи по калькулятору в интернет магазине «Мастерская жалюзи» ☎ 8-800-775-72-38.',
            $this->getName());
    }
    
    public function getTitleComputed(): string
    {
        if (!empty($this->getTitle())) {
            return $this->getTitle();
        }
        
        return sprintf('%s. Расчет жалюзи по калькулятору', $this->getName());
    }
}