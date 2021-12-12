<?php

namespace App\Entity;

use App\Entity\Traits\CatalogCalcTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatalogRepository")
 */
class Catalog extends Page
{
    use CatalogCalcTrait;
    
    public const TYPE = 'catalog';
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
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recommendedTitle;
    
    /**
     * @ORM\OneToMany(targetEntity=WorkExample::class, mappedBy="catalog")
     */
    private Collection $workExamples;
    
    public function __construct()
    {
        parent::__construct();
        $this->workExamples = new ArrayCollection();
    }
    
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
    
    public function getRecommendedTitle(): ?string
    {
        return $this->recommendedTitle;
    }
    
    public function setRecommendedTitle(?string $recommendedTitle): self
    {
        $this->recommendedTitle = $recommendedTitle;
        
        return $this;
    }
    
    public function getDescriptionComputed()
    {
        if (!empty($this->getDescription())) {
            return $this->getDescription();
        }
        
        return sprintf('%s купить недорого в Москве. ⭐ Выезд и замер бесплатно! ✅ Изготовление жалюзи с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в интернет магазине «Мастерская жалюзи» ☎ 8-800-775-72-38.',
            $this->getName(), $this->getName());
    }
    
    public function getUnits(): string
    {
        if (in_array(explode('/', $this->getUri())[0], ['markizyi', 'rulonnyie-shtoryi'])) {
            return 'руб за изделие';
        }
    
        return parent::getUnits();
    }
    
    public function getTurboContentTemplate(): string
    {
        return 'turbo/catalog/content.html.twig';
    }
    
    /**
     * @return Collection<WorkExample>
     */
    public function getWorkExamples(): Collection
    {
        return $this->workExamples;
    }
    
    public function addWorkExample(WorkExample $workExample): self
    {
        if (!$this->workExamples->contains($workExample)) {
            $this->workExamples[] = $workExample;
            $workExample->setCatalog($this);
        }
        
        return $this;
    }
    
    public function removeWorkExample(WorkExample $workExample): self
    {
        if ($this->workExamples->removeElement($workExample)) {
            // set the owning side to null (unless already changed)
            if ($workExample->getCatalog() === $this) {
                $workExample->setCatalog(null);
            }
        }
        
        return $this;
    }
}
