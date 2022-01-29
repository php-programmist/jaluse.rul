<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaterialRepository")
 */
class Material
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $cardMaterialName = null;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $cardTypeName = null;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="material")
     */
    private $products;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Catalog", mappedBy="material")
     */
    private $catalogs;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Type", inversedBy="materials")
     */
    private $type;
    
    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $ordering = 0;
    
    /**
     * @ORM\OneToMany(targetEntity=WorkExample::class, mappedBy="productMaterial")
     */
    private Collection $workExamples;
    
    public function __construct()
    {
        $this->products     = new ArrayCollection();
        $this->type         = new ArrayCollection();
        $this->catalogs     = new ArrayCollection();
        $this->workExamples = new ArrayCollection();
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
            $product->setMaterial($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getMaterial() === $this) {
                $product->setMaterial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Catalog[]
     */
    public function getCatalogs(): Collection
    {
        return $this->catalogs;
    }

    public function addCatalog(Catalog $catalog): self
    {
        if (!$this->catalogs->contains($catalog)) {
            $this->catalogs[] = $catalog;
            $catalog->setMaterial($this);
        }

        return $this;
    }

    public function removeCatalog(Catalog $catalog): self
    {
        if ($this->catalogs->contains($catalog)) {
            $this->catalogs->removeElement($catalog);
            // set the owning side to null (unless already changed)
            if ($catalog->getMaterial() === $this) {
                $catalog->setMaterial(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Type[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }
    
    public function removeType(Type $type): self
    {
        if ($this->type->contains($type)) {
            $this->type->removeElement($type);
        }
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getOrdering(): int
    {
        return $this->ordering;
    }
    
    /**
     * @param int $ordering
     *
     * @return $this
     */
    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;
        
        return $this;
    }
    
    /**
     * @return Collection|WorkExample[]
     */
    public function getWorkExamples(): Collection
    {
        return $this->workExamples;
    }
    
    public function addWorkExample(WorkExample $workExample): self
    {
        if (!$this->workExamples->contains($workExample)) {
            $this->workExamples[] = $workExample;
            $workExample->setProductMaterial($this);
        }
        
        return $this;
    }
    
    public function removeWorkExample(WorkExample $workExample): self
    {
        if ($this->workExamples->removeElement($workExample)) {
            // set the owning side to null (unless already changed)
            if ($workExample->getProductMaterial() === $this) {
                $workExample->setProductMaterial(null);
            }
        }
    
        return $this;
    }
    
    /**
     * @return ?string
     */
    public function getCardMaterialName(): ?string
    {
        return $this->cardMaterialName ?? $this->name;
    }
    
    /**
     * @param ?string $cardMaterialName
     *
     * @return $this
     */
    public function setCardMaterialName(?string $cardMaterialName): self
    {
        $this->cardMaterialName = $cardMaterialName;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getCardTypeName(): ?string
    {
        return $this->cardTypeName ?? $this->name;
    }
    
    /**
     * @param string|null $cardTypeName
     *
     * @return $this
     */
    public function setCardTypeName(?string $cardTypeName): self
    {
        $this->cardTypeName = $cardTypeName;
        
        return $this;
    }
}
