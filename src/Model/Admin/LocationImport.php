<?php

namespace App\Model\Admin;

use App\Entity\Catalog;
use App\Model\GeoProduct\ZhalyuziGeoProduct;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LocationImport implements SlugConfig
{
    private ?UploadedFile $xlsFile = null;
    
    private int $firstRow = 2;
    
    private ?Catalog $parent = null;
    
    private ?Catalog $catalog = null;
    
    private ?UploadedFile $images = null;
    
    private ?string $removeFromName = null;
    
    private ?string $baseUri = null;
    
    private string $materials = '';
    
    private string $type = '';
    
    private string $subTypes = '';
    
    private string $geoProductType = ZhalyuziGeoProduct::TYPE;
    
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
    public function getImages(): ?UploadedFile
    {
        return $this->images;
    }
    
    /**
     * @param UploadedFile|null $images
     *
     * @return $this
     */
    public function setImages(?UploadedFile $images): self
    {
        $this->images = $images;
        
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
     * @return string|null
     */
    public function getBaseUri(): ?string
    {
        return trim($this->baseUri ? : $this->getParent()?->getUri(), ' /');
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
    
    /**
     * @return Catalog|null
     */
    public function getParent(): ?Catalog
    {
        return $this->parent;
    }
    
    /**
     * @param Catalog|null $parent
     *
     * @return $this
     */
    public function setParent(?Catalog $parent): self
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMaterials(): string
    {
        return $this->materials;
    }
    
    /**
     * @param string $materials
     *
     * @return $this
     */
    public function setMaterials(string $materials): self
    {
        $this->materials = $materials;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSubTypes(): string
    {
        return $this->subTypes;
    }
    
    /**
     * @param string $subTypes
     *
     * @return $this
     */
    public function setSubTypes(string $subTypes): self
    {
        $this->subTypes = $subTypes;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGeoProductType(): string
    {
        return $this->geoProductType;
    }
    
    /**
     * @param string $geoProductType
     *
     * @return $this
     */
    public function setGeoProductType(string $geoProductType): self
    {
        $this->geoProductType = $geoProductType;
        
        return $this;
    }
    
}