<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="color")
     */
    private $products;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alias;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hex;
    
    private int $productsCount = 0;
    
    private string $link = '';
    
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setColor($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getColor() === $this) {
                $product->setColor(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getHex(): ?string
    {
        return $this->hex;
    }
    
    public function setHex(string $hex): self
    {
        $this->hex = $hex;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getProductsCount(): int
    {
        return $this->productsCount;
    }
    
    /**
     * @param int $productsCount
     *
     * @return $this
     */
    public function setProductsCount(int $productsCount): self
    {
        $this->productsCount = $productsCount;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
    
    /**
     * @param string $link
     *
     * @return $this
     */
    public function setLink(string $link): self
    {
        $this->link = $link;
        
        return $this;
    }
    
}
