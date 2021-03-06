<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product extends Page
{
    public const TYPE = 'product';
    const RULON_TYPE_ID = 133;
    const ISOLITE_TYPE_ID = 178;
    const SERIALIZER_ATTRIBUTES = [
        'id',
        'price',
        'imageSmall',
        'imageCatalog',
        'imageBig',
        'name',
        'uri',
        'colorId',
        'colorName',
        'materialName',
        'categoryName',
        'typeName',
        'discount',
        'matrixId',
        'matrixFolder',
        'calculationType',
        'minPrice',
    ];
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $price;

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
     * @ORM\Column(type="integer",nullable=true)
     */
    private $discount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $matrix_id;
    
    private $min_price=0;

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
        return 'Не указан';
    }
    
    public function getTypeName()
    {
        if ($this->getType()) {
            return $this->getType()->getName();
        }
        return 'Не указан';
    }
    
    public function getTypeNameForPage()
    {
        if ($this->getType() && $this->getType()->getId() === self::ISOLITE_TYPE_ID) {
            return 'Горизонтальные';
        }
        return $this->getTypeName();
    }
    
    public function getMaterialName()
    {
        if ($this->getMaterial()) {
            return $this->getMaterial()->getName();
        }
        return 'Не указан';
    }
    
    public function getCategoryName()
    {
        if ($this->getCategory()) {
            return $this->getCategory()->getName();
        }
        return 'Без категории';
    }
    
    public function getMatrixFolder()
    {
        $parent = $this->getParent();
        if ($parent && $parent instanceof Catalog) {
            return $parent->getMatrixFolder();
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
    
    public function getCardImageUrl():string
    {
        return $this->getImageBig();
    }

    public function getMatrixId(): ?int
    {
        return $this->matrix_id;
    }

    public function setMatrixId(int $matrix_id): self
    {
        $this->matrix_id = $matrix_id;

        return $this;
    }
    
    public function getTypeForPage()
    {
        if ($this->getType() && $this->getType()->getId() === self::RULON_TYPE_ID) {
            return $this->getMaterialName();
        }
    
        if ($this->getType()->getId() === self::ISOLITE_TYPE_ID) {
            return 'Жалюзи Isolite';
        }
    
        if ($this->getType()) {
            return $this->getMaterialName().' жалюзи';
        }
    
        return 'Не установлен';
    }
    
    public function getMaterialForPage()
    {
        if ($this->getType() && $this->getType()->getId() === self::RULON_TYPE_ID) {
            return 'ткань';
        }
    
        if ($this->getType()) {
            return $this->getMaterialName();
        }
    
        return 'Не установлен';
    }
    
    public function getMinPrice():?int
    {
        return $this->min_price;
    }
    
    public function getMinSize():string
    {
        return $this->getCalculationType() === 'simple' ? '100 x 100 см' : '40 x 50 см';
    }
    
    
    public function setMinPrice(int $min_price): self
    {
        $this->min_price = $min_price;
        return $this;
    }
    
    public function getCalculationType()
    {
        if ( ! $this->getType()) {
            return 'simple';
        }
        return $this->getType()->getCalculationType();
    }
    
    public function getDescriptionComputed()
    {
        if (!empty($this->getDescription())) {
            return $this->getDescription();
        }
        return sprintf('%s купить от производителя в Москве. ⭐ Выезд и замер бесплатно! ✅ Изготовление с установкой за 1-4 дня. ✅ Гарантия 2 года. ⭐ %s по низким ценам в интернет магазине «Мастерская жалюзи» ☎ 8-800-775-72-38.',
            $this->getName(),$this->getName());
    }
}
