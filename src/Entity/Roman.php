<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RomanRepository")
 */
class Roman extends Page
{
    public const TYPE = 'roman';
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
        return 'img/roman/';
    }
}
