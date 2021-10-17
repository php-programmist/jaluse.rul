<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article extends Page
{
    public const TYPE = 'article';
    
    /**
     * @ORM\ManyToMany(targetEntity=Product::class)
     */
    private Collection $products;
    
    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $views = 0;
    
    public function __construct()
    {
        parent::__construct();
        $this->products = new ArrayCollection();
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
        }
    
        return $this;
    }
    
    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }
    
    /**
     * @param int $views
     *
     * @return $this
     */
    public function setViews(int $views): self
    {
        $this->views = $views;
    
        return $this;
    }
    
    public function getUri(): ?string
    {
        return parent::getUri() ?? 'articles/...';
    }
    
    public function incrementViews(): void
    {
        $this->views++;
    }
}
