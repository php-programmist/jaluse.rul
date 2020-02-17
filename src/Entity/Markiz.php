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

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $markizDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
    
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMarkizDescription(): ?string
    {
        return $this->markizDescription;
    }

    public function setMarkizDescription(?string $markizDescription): self
    {
        $this->markizDescription = $markizDescription;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
    
    public function getMarkizImgFolder()
    {
        return '/img/markiz/';
    }
    
    public function getImageUrl()
    {
        if ( ! $this->image) {
            return null;
        }
        return $this->getMarkizImgFolder(). $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
