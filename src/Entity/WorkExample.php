<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkExampleRepository")
 */
class WorkExample
{
    public const IMAGES_PATH = 'img/work_example';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $address = null;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $type = null;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $collection = null;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $color = null;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $number = 1;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $place = null;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $location = null;
    
    /**
     * @ORM\Column(type="integer", options={"default": 3})
     */
    private int $makeDays = 3;
    /**
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private int $installDays = 1;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $totalPrice = 0;
    
    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $measuringPrice = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $position = 0;
    
    private array $images = [];
    
    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="workExamples")
     */
    private ?Product $product = null;
    
    /**
     * @ORM\ManyToOne(targetEntity=Catalog::class, inversedBy="workExamples")
     */
    private ?Catalog $catalog = null;
    
    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="workExamples")
     */
    private ?Type $productType = null;
    
    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="workExamples")
     */
    private ?Material $productMaterial = null;
    
    /**
     * @ORM\ManyToMany(targetEntity=Page::class, inversedBy="workExamplesOfPage")
     */
    private Collection $pages;
    
    public function __construct()
    {
        $this->pages = new ArrayCollection();
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
    
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        
        return $this;
    }
    
    public function getPosition(): ?int
    {
        return $this->position;
    }
    
    public function setPosition(int $position): self
    {
        $this->position = $position;
        
        return $this;
    }
    
    public function getImgFolder(): string
    {
        return self::IMAGES_PATH . '/' . $this->getId();
    }
    
    public function getImages(): array
    {
        return $this->images;
    }
    
    /**
     * @param array $images
     *
     * @return WorkExample
     */
    public function setImages(array $images): self
    {
        $this->images = $images;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }
    
    /**
     * @param string|null $type
     *
     * @return $this
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getCollection(): ?string
    {
        return $this->collection;
    }
    
    /**
     * @param string|null $collection
     *
     * @return $this
     */
    public function setCollection(?string $collection): self
    {
        $this->collection = $collection;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }
    
    /**
     * @param string|null $color
     *
     * @return $this
     */
    public function setColor(?string $color): self
    {
        $this->color = $color;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }
    
    /**
     * @param int $number
     *
     * @return $this
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }
    
    /**
     * @param string|null $place
     *
     * @return $this
     */
    public function setPlace(?string $place): self
    {
        $this->place = $place;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }
    
    /**
     * @param string|null $location
     *
     * @return $this
     */
    public function setLocation(?string $location): self
    {
        $this->location = $location;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMakeDays(): int
    {
        return $this->makeDays;
    }
    
    /**
     * @param int $makeDays
     *
     * @return $this
     */
    public function setMakeDays(int $makeDays): self
    {
        $this->makeDays = $makeDays;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getInstallDays(): int
    {
        return $this->installDays;
    }
    
    /**
     * @param int $installDays
     *
     * @return $this
     */
    public function setInstallDays(int $installDays): self
    {
        $this->installDays = $installDays;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }
    
    /**
     * @param int $totalPrice
     *
     * @return $this
     */
    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;
        
        return $this;
    }
    
    public function __toString()
    {
        return $this->name . ' (' . $this->address . ')';
    }
    
    public function getProduct(): ?Product
    {
        return $this->product;
    }
    
    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        
        return $this;
    }
    
    public function getCatalog(): ?Catalog
    {
        return $this->catalog;
    }
    
    public function setCatalog(?Catalog $catalog): self
    {
        $this->catalog = $catalog;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMeasuringPrice(): int
    {
        return $this->measuringPrice;
    }
    
    /**
     * @param int $measuringPrice
     *
     * @return $this
     */
    public function setMeasuringPrice(int $measuringPrice): self
    {
        $this->measuringPrice = $measuringPrice;
        
        return $this;
    }
    
    public function getProductType(): ?Type
    {
        return $this->productType;
    }
    
    public function setProductType(?Type $productType): self
    {
        $this->productType = $productType;
        
        return $this;
    }
    
    public function getProductMaterial(): ?Material
    {
        return $this->productMaterial;
    }
    
    public function setProductMaterial(?Material $productMaterial): self
    {
        $this->productMaterial = $productMaterial;
        
        return $this;
    }
    
    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }
    
    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
        }
    
        return $this;
    }
    
    public function removePage(Page $page): self
    {
        $this->pages->removeElement($page);
        
        return $this;
    }
    
    public function getFilters(): string
    {
        $filters = [];
        if (null !== $this->getProductType()) {
            $filters[] = $this->getProductType()->getName();
            if (in_array($this->getProductType()->getName(), ['Вертикальные', ['Горизонтальные']], true)) {
                $filters[] = 'На пластиковые окна';
            }
        }
        
        if (null !== $this->getProductMaterial()) {
            $filters[] = $this->getProductMaterial()->getName();
        }
        
        return implode(',', $filters);
    }
    
}
