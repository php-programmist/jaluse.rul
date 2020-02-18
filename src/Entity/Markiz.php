<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkizRepository")
 */
class Markiz extends Page
{
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;
    
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }
    
    public function getCardImgFolder()
    {
        return 'img/markiz/';
    }
    
}
