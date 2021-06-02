<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Vich\Uploadable
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
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="image_small")
     */
    protected ?string $imageSmallName = null;
    
    /**
     * @Vich\UploadableField(mapping="product_images_small", fileNameProperty="imageSmallName")
     * @var File
     */
    protected $imageSmallFile;
    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="image_big")
     */
    protected ?string $imageBigName = null;
    
    /**
     * @Vich\UploadableField(mapping="product_images_big", fileNameProperty="imageBigName")
     * @var File
     */
    protected $imageBigFile;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="image_catalog")
     */
    protected ?string $imageCatalogName = null;
    
    /**
     * @Vich\UploadableField(mapping="product_images_catalog", fileNameProperty="imageCatalogName")
     * @var File
     */
    protected $imageCatalogFile;
    
    private $min_price = 0;
    
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
    
    public function getYmlCategory(): array
    {
        if (strpos($this->getUri(), 'zhalyuzi') === 0) {
            return ['id' => 1, 'name' => 'Жалюзи'];
        }
        
        return ['id' => 2, 'name' => 'Рулонные шторы'];
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
    
    public function getImageSmall(): string
    {
        if (null !== $this->imageSmallName) {
            $file_name = $this->imageSmallName;
        } else {
            $segments  = explode('/', $this->getUri());
            $file_name = array_pop($segments) . '.jpg';
        }
        
        return '/' . $this->productImgSmallFolder() . $file_name;
    }
    
    public function getImageBig(): string
    {
        if (null !== $this->imageBigName) {
            $file_name = $this->imageBigName;
        } else {
            $segments  = explode('/', $this->getUri());
            $file_name = array_pop($segments) . '.jpg';
        }
        
        return '/' . $this->productImgBigFolder() . $file_name;
    }
    
    public function getImageCatalog(): string
    {
        if (null !== $this->imageCatalogName) {
            $file_name = $this->imageCatalogName;
        } else {
            $segments  = explode('/', $this->getUri());
            $file_name = array_pop($segments) . '.jpg';
        }
        
        return '/' . $this->productImgCatalogFolder() . $file_name;
    }
    
    public function getCardImageUrl(): string
    {
        return $this->getImageBig();
    }
    
    public function getCardHeader(): string
    {
        return $this->getName();
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
            $this->getName(), $this->getName());
    }
    
    /**
     * @return string|null
     */
    public function getImageSmallName(): ?string
    {
        return $this->imageSmallName;
    }
    
    /**
     * @return string|null
     */
    public function getImageBigName(): ?string
    {
        return $this->imageBigName;
    }
    
    /**
     * @return string|null
     */
    public function getImageCatalogName(): ?string
    {
        return $this->imageCatalogName;
    }
    
    /**
     * @param string|null $imageSmallName
     *
     * @return $this
     */
    public function setImageSmallName(?string $imageSmallName): self
    {
        $this->imageSmallName = $imageSmallName;
        
        return $this;
    }
    
    /**
     * @param string|null $imageBigName
     *
     * @return $this
     */
    public function setImageBigName(?string $imageBigName): self
    {
        $this->imageBigName = $imageBigName;
        
        return $this;
    }
    
    /**
     * @param string|null $imageCatalogName
     *
     * @return $this
     */
    public function setImageCatalogName(?string $imageCatalogName): self
    {
        $this->imageCatalogName = $imageCatalogName;
        
        return $this;
    }
    
    /**
     * @return File|null
     */
    public function getImageSmallFile(): ?File
    {
        return $this->imageSmallFile;
    }
    
    /**
     * @param File|null $imageSmallFile
     *
     * @return $this
     */
    public function setImageSmallFile(File $imageSmallFile = null): self
    {
        $this->imageSmallFile = $imageSmallFile;
        if ($imageSmallFile) {
            $this->modified_at = new DateTime('now');
        }
        
        return $this;
    }
    
    /**
     * @return File|null
     */
    public function getImageBigFile(): ?File
    {
        return $this->imageBigFile;
    }
    
    /**
     * @param File|null $imageBigFile
     *
     * @return $this
     */
    public function setImageBigFile(File $imageBigFile = null): self
    {
        $this->imageBigFile = $imageBigFile;
        if ($imageBigFile) {
            $this->modified_at = new DateTime('now');
        }
        
        return $this;
    }
    
    /**
     * @return File|null
     */
    public function getImageCatalogFile(): ?File
    {
        return $this->imageCatalogFile;
    }
    
    /**
     * @param File|null $imageCatalogFile
     *
     * @return $this
     */
    public function setImageCatalogFile(File $imageCatalogFile = null): self
    {
        $this->imageCatalogFile = $imageCatalogFile;
        if ($imageCatalogFile) {
            $this->modified_at = new DateTime('now');
        }
        
        return $this;
    }
    
    public function productImgFolder(): string
    {
        $segments = explode('/', $this->getUri());
        array_pop($segments);
        $folder = array_pop($segments);
        
        return 'img/products/' . $folder . '/';
    }
    
    public function productImgSmallFolder(): string
    {
        return $this->productImgFolder() . 'small/';
    }
    
    public function productImgBigFolder(): string
    {
        return $this->productImgFolder() . 'big/';
    }
    
    public function productImgCatalogFolder(): string
    {
        return $this->productImgFolder() . 'catalog/';
    }
    
}
