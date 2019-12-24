<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product extends Page
{
    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Color", inversedBy="products")
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="products")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Material", inversedBy="products")
     */
    private $material;

    /**
     * @ORM\Column(type="boolean")
     */
    private $popular;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $discount = 0;

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getPopular(): ?bool
    {
        return $this->popular;
    }

    public function setPopular(bool $popular): self
    {
        $this->popular = $popular;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
    
    public function getColorId()
    {
        if ($this->getColor()) {
            return $this->getColor()->getId();
        }
        return 0;
    }
    
    public function getColorName()
    {
        if ($this->getColor()) {
            return $this->getColor()->getName();
        }
        return '';
    }
    
    public function getMaterialName()
    {
        if ($this->getMaterial()) {
            return $this->getMaterial()->getName();
        }
        return '';
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
    
    public function getImageSmall()
    {
        $segments = explode('/', $this->getUri());
        $file_name = array_pop($segments).'.jpg';
        $folder = array_pop($segments);
        return '/img/products/'.$folder.'/small/'.$file_name;
    }
    
    public function getImageBig()
    {
        $segments = explode('/', $this->getUri());
        $file_name = array_pop($segments).'.jpg';
        $folder = array_pop($segments);
        return '/img/products/'.$folder.'/big/'.$file_name;
    }
    
    public function getImageCatalog()
    {
        $segments = explode('/', $this->getUri());
        $file_name = array_pop($segments).'.jpg';
        $folder = array_pop($segments);
        return '/img/products/'.$folder.'/catalog/'.$file_name;
    }
}
