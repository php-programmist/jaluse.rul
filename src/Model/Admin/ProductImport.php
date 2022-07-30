<?php

namespace App\Model\Admin;

use App\Entity\Catalog;
use App\Entity\Material;
use App\Entity\Type;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductImport
{
    private ?UploadedFile $xlsFile = null;
    
    private int $firstRow = 2;
    
    private ?Catalog $catalog = null;
    
    private ?Type $type = null;
    
    private ?Material $material = null;
    
    private ?UploadedFile $imagesSmall = null;
    
    private ?UploadedFile $imagesBig = null;
    
    private ?UploadedFile $imagesCatalog = null;
    
    private ?string $removeFromName = null;
    
    private ?string $baseUri = null;
    
    private bool $matrix = false;
    
    /**
     * @return UploadedFile|null
     */
    public function getXlsFile(): ?UploadedFile
    {
        return $this->xlsFile;
    }
    
    /**
     * @param UploadedFile|null $xlsFile
     *
     * @return $this
     */
    public function setXlsFile(?UploadedFile $xlsFile): self
    {
        $this->xlsFile = $xlsFile;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getFirstRow(): int
    {
        return $this->firstRow;
    }
    
    /**
     * @param int $firstRow
     *
     * @return $this
     */
    public function setFirstRow(int $firstRow): self
    {
        $this->firstRow = $firstRow;
        
        return $this;
    }
    
    /**
     * @return Catalog|null
     */
    public function getCatalog(): ?Catalog
    {
        return $this->catalog;
    }
    
    /**
     * @param Catalog|null $catalog
     *
     * @return $this
     */
    public function setCatalog(?Catalog $catalog): self
    {
        $this->catalog = $catalog;
        
        return $this;
    }
    
    /**
     * @return UploadedFile|null
     */
    public function getImagesSmall(): ?UploadedFile
    {
        return $this->imagesSmall;
    }
    
    /**
     * @param UploadedFile|null $imagesSmall
     *
     * @return $this
     */
    public function setImagesSmall(?UploadedFile $imagesSmall): self
    {
        $this->imagesSmall = $imagesSmall;
        
        return $this;
    }
    
    /**
     * @return UploadedFile|null
     */
    public function getImagesBig(): ?UploadedFile
    {
        return $this->imagesBig;
    }
    
    /**
     * @param UploadedFile|null $imagesBig
     *
     * @return $this
     */
    public function setImagesBig(?UploadedFile $imagesBig): self
    {
        $this->imagesBig = $imagesBig;
        
        return $this;
    }
    
    /**
     * @return UploadedFile|null
     */
    public function getImagesCatalog(): ?UploadedFile
    {
        return $this->imagesCatalog;
    }
    
    /**
     * @param UploadedFile|null $imagesCatalog
     *
     * @return $this
     */
    public function setImagesCatalog(?UploadedFile $imagesCatalog): self
    {
        $this->imagesCatalog = $imagesCatalog;
        
        return $this;
    }
    
    /**
     * @return Type|null
     */
    public function getType(): ?Type
    {
        return $this->type;
    }
    
    /**
     * @param Type|null $type
     *
     * @return $this
     */
    public function setType(?Type $type): self
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return Material|null
     */
    public function getMaterial(): ?Material
    {
        return $this->material;
    }
    
    /**
     * @param Material|null $material
     *
     * @return $this
     */
    public function setMaterial(?Material $material): self
    {
        $this->material = $material;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getRemoveFromName(): ?string
    {
        return $this->removeFromName;
    }
    
    /**
     * @param string|null $removeFromName
     *
     * @return $this
     */
    public function setRemoveFromName(?string $removeFromName): self
    {
        $this->removeFromName = $removeFromName;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isMatrix(): bool
    {
        return $this->matrix;
    }
    
    /**
     * @param bool $matrix
     *
     * @return $this
     */
    public function setMatrix(bool $matrix): self
    {
        $this->matrix = $matrix;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getBaseUri(): ?string
    {
        return trim($this->baseUri ? : $this->getCatalog()?->getUri(), ' /');
    }
    
    /**
     * @param string|null $baseUri
     *
     * @return $this
     */
    public function setBaseUri(?string $baseUri): self
    {
        $this->baseUri = $baseUri;
        
        return $this;
    }
    
}