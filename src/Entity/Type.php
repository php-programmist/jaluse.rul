<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $cardTypeName = null;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="type")
     */
    private $products;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Catalog", mappedBy="type")
     */
    private $catalogs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Material", mappedBy="type")
     * @ORM\OrderBy({"ordering" = "ASC", "id" = "ASC", })
     */
    private $materials;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $show_main_page_calc;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $calculation_type;
    
    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $ordering = 0;
    
    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private bool $hideCategories = false;
    
    /**
     * @ORM\OneToMany(targetEntity=WorkExample::class, mappedBy="productType")
     */
    private Collection $workExamples;
    
    public function __construct()
    {
        $this->products     = new ArrayCollection();
        $this->materials    = new ArrayCollection();
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
            $product->setType($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getType() === $this) {
                $product->setType(null);
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
            $catalog->setType($this);
        }

        return $this;
    }

    public function removeCatalog(Catalog $catalog): self
    {
        if ($this->catalogs->contains($catalog)) {
            $this->catalogs->removeElement($catalog);
            // set the owning side to null (unless already changed)
            if ($catalog->getType() === $this) {
                $catalog->setType(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string)$this->getName();
    }

    /**
     * @return Collection|Material[]
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials[] = $material;
            $material->addType($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        if ($this->materials->contains($material)) {
            $this->materials->removeElement($material);
            $material->removeType($this);
        }

        return $this;
    }

    public function getShowMainPageCalc(): ?bool
    {
        return $this->show_main_page_calc;
    }

    public function setShowMainPageCalc(bool $show_main_page_calc): self
    {
        $this->show_main_page_calc = $show_main_page_calc;

        return $this;
    }

    public function getCalculationType(): ?string
    {
        return $this->calculation_type;
    }
    
    public function setCalculationType(string $calculation_type): self
    {
        $this->calculation_type = $calculation_type;
        
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
            $workExample->setProductType($this);
        }
        
        return $this;
    }
    
    public function removeWorkExample(WorkExample $workExample): self
    {
        if ($this->workExamples->removeElement($workExample)) {
            // set the owning side to null (unless already changed)
            if ($workExample->getProductType() === $this) {
                $workExample->setProductType(null);
            }
        }
    
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isHideCategories(): bool
    {
        return $this->hideCategories;
    }
    
    /**
     * @param bool $hideCategories
     *
     * @return $this
     */
    public function setHideCategories(bool $hideCategories): self
    {
        $this->hideCategories = $hideCategories;
    
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $cardMaterialName = null;
    
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
    
    /**
     * @return string|null
     */
    public function getCardMaterialName(): ?string
    {
        return $this->cardMaterialName ?? $this->name;
    }
    
    /**
     * @param string|null $cardMaterialName
     *
     * @return $this
     */
    public function setCardMaterialName(?string $cardMaterialName): self
    {
        $this->cardMaterialName = $cardMaterialName;
        
        return $this;
    }
}
