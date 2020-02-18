<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatalogRepository")
 */
class Catalog extends Page
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matrix_folder;

    public function getMatrixFolder(): ?string
    {
        return $this->matrix_folder;
    }

    public function setMatrixFolder(?string $matrix_folder): self
    {
        $this->matrix_folder = $matrix_folder;

        return $this;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="catalogs")
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Material", inversedBy="catalogs")
     */
    private $material;
    
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
    
    public function getType(): ?Type
    {
        if ($this->type) {
            return $this->type;
        }
        $parent = $this->getParent();
        if ($parent && $parent instanceof Catalog) {
            return $parent->getType();
        }
        return null;
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
}
