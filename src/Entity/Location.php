<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location extends Page
{
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
}
