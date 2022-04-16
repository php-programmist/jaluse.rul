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
    private ?string $matrix_folder = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="catalogs")
     */
    private ?Type $type = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Material", inversedBy="catalogs")
     */
    private ?Material $material = null;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $price = null;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $recommendedTitle = null;
    
    /**
     * @ORM\OneToMany(targetEntity=WorkExample::class, mappedBy="catalog")
     */
    private Collection $workExamples;
    
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $filters = [];
    
    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $hideCategories = false;
    
    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $hideFilters = false;
    
    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $premium = false;
    
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
        if ($this->material) {
            return $this->material;
        }
    
        $parent = $this->getParent();
        if ($parent && $parent instanceof Catalog) {
            return $parent->getMaterial();
        }
    
        return null;
    }
    
    public function setMaterial(?Material $material): self
    {
        $this->material = $material;
        
        return $this;
    }
    
    public function getRecommendedTitle(): ?string
    {
        return $this->recommendedTitle ?? 'Рекомендуемые ' . $this->name;
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
    
    public function isHideCategories(): bool
    {
        if ($this->hideCategories) {
            return true;
        }
        
        return $this->getType()?->isHideCategories() ?? false;
    }
    
    public function getMatrixFolder(): ?string
    {
        $parent = $this->getParent();
        if (
            null === $this->matrix_folder
            && null !== $parent
            && $parent instanceof Catalog
        ) {
            return $parent->getMatrixFolder();
        }
        
        return $this->matrix_folder;
    }
    
    public function setMatrixFolder(?string $matrix_folder): self
    {
        $this->matrix_folder = $matrix_folder;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters ?? [];
    }
    
    /**
     * @param array|null $filters
     *
     * @return $this
     */
    public function setFilters(?array $filters): self
    {
        $this->filters = $filters;
        
        return $this;
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
     * @return bool
     */
    public function isHideFilters(): bool
    {
        return $this->hideFilters;
    }
    
    /**
     * @param bool $hideFilters
     *
     * @return $this
     */
    public function setHideFilters(bool $hideFilters): self
    {
        $this->hideFilters = $hideFilters;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isPremium(): bool
    {
        return $this->premium;
    }
    
    /**
     * @param bool $premium
     *
     * @return $this
     */
    public function setPremium(bool $premium): self
    {
        $this->premium = $premium;
    
        return $this;
    }
    
    public function isShowSummary(): bool
    {
        return null !== $this->nameGenitive;
    }
    
    public function getAvailableTypes(): ?array
    {
        if ($this->uri === 'zhalyuzi') {
            return [132, 133, 175, 178]; //Все, кроме вертикальных
        }
        $types = $this->getFilters()['type'] ?? null;
        if (null === $types) {
            return null;
        }
        $typesArray = explode(',', $types);
    
        return array_map(static fn(string $item) => (int)$item, $typesArray);
    }
    
    public function getSelectedCategory(): int
    {
        $categories = $this->getFilters()['category'] ?? null;
        if (null === $categories) {
            return 1;
        }
        $categoriesArray = explode(',', $categories);
        
        return (int)$categoriesArray[0];
    }
}
