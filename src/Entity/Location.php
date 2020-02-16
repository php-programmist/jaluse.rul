<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @Vich\Uploadable
 */
class Location extends Page
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $locationDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locationImage;
    
    /**
     * @Vich\UploadableField(mapping="location_images", fileNameProperty="locationImage")
     * @var File
     */
    protected $locationImageFile;

    public function getLocationDescription(): ?string
    {
        return $this->locationDescription;
    }

    public function setLocationDescription(?string $locationDescription): self
    {
        $this->locationDescription = $locationDescription;

        return $this;
    }

    public function getLocationImage(): ?string
    {
        return $this->locationImage;
    }

    public function setLocationImage(?string $locationImage): self
    {
        $this->locationImage = $locationImage;

        return $this;
    }
    
    public function setLocationImageFile(File $image = null)
    {
        $this->seoImageFile = $image;
        
        if ($image) {
            $this->setModifiedAt(new \DateTime('now'));
        }
    }
    
    public function getLocationImageFile()
    {
        return $this->seoImageFile;
    }
}
