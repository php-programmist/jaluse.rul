<?php

namespace App\Entity;

use App\Entity\Contracts\TurboPageInterface;
use App\Entity\Traits\RatingTrait;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="page_type", type="string")
 * @ORM\DiscriminatorMap({
 *     Region::TYPE = "Region",
 *     District::TYPE = "District",
 *     Metro::TYPE = "Metro",
 *     City::TYPE = "City",
 *     Product::TYPE = "Product",
 *     Catalog::TYPE = "Catalog",
 *     Simple::TYPE = "Simple",
 *     Location::TYPE = "Location",
 *     Roman::TYPE = "Roman",
 *     Roll::TYPE = "Roll",
 *     Markiz::TYPE = "Markiz",
 * })
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Page implements TurboPageInterface
{
    use RatingTrait;
    
    const MIN_RATING_VALUE = 4.7;
    const MAX_RATING_VALUE = 4.9;
    const MIN_RATING_COUNT = 8;
    const MAX_RATING_COUNT = 35;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $uri;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title = null;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    protected $description = null;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $published =1;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $yml = false;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $turbo = false;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $modified_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="pages")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="parent")
     */
    protected $pages;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $seoImage;
    
    /**
     * @Vich\UploadableField(mapping="seo_images", fileNameProperty="seoImage")
     * @var File
     */
    protected $seoImageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $ourWorksFolder;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cardImage;
    
    /**
     * @Vich\UploadableField(mapping="card_images", fileNameProperty="cardImage")
     * @var File
     */
    protected $cardImageFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $cardDescription;
    
    public function __construct()
    {
        $this->created_at  = new DateTimeImmutable();
        $this->modified_at = new DateTimeImmutable();
        $this->pages       = new ArrayCollection();
        $this->generateRatingAndCount();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function getPath(): string
    {
        if ($this->uri === '/' ) {
            return '/';
        }
        return '/'.$this->uri.'/';
    }

    public function setUri(string $uri)
    {
        $this->uri = trim($uri);

        return $this;
    }

    public function setPath(string $path)
    {
        return $this->setUri($path);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published)
    {
        $this->published = $published;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): Page
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(DateTimeInterface $modified_at)
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(?self $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(self $page)
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setParent($this);
        }

        return $this;
    }

    public function removePage(self $page)
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getParent() === $this) {
                $page->setParent(null);
            }
        }

        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getSeoImage(): ?string
    {
        return $this->seoImage;
    }

    public function setSeoImage(?string $seoImage): self
    {
        $this->seoImage = $seoImage;

        return $this;
    }
    
    public function setSeoImageFile(File $image = null)
    {
        $this->seoImageFile = $image;
        
        if ($image) {
            $this->modified_at = new DateTime('now');
        }
    }
    
    public function setCardImageFile(File $image = null): void
    {
        $this->cardImageFile = $image;
        
        if ($image) {
            $this->modified_at = new DateTime('now');
        }
    }
    
    public function getSeoImageFile(): ?File
    {
        return $this->seoImageFile;
    }
    
    public function getCardImageFile(): ?File
    {
        return $this->cardImageFile;
    }
    
    public function getSeoFirstPart():string
    {
        if (empty($this->getContent())) {
            return '';
        }
        $parts = preg_split('#<hr.*?>#',$this->getContent(),2);
        return $parts[0];
    }
    
    public function getSeoSecondPart():string
    {
        if (empty($this->getContent())) {
            return '';
        }
        $parts = preg_split('#<hr.*?>#',$this->getContent(),2);
        return $parts[1]??'';
    }

    public function getOurWorksFolder(): ?string
    {
        return $this->ourWorksFolder;
    }

    public function setOurWorksFolder(?string $ourWorksFolder): self
    {
        $this->ourWorksFolder = $ourWorksFolder;

        return $this;
    }
    
    public function getSeoImgFolder()
    {
        return 'img/seo_images/';
    }
    
    public function getCardImgFolder()
    {
        return 'img/card/';
    }
    
    public function getSeoImageUrl()
    {
        if ( ! $this->getSeoImage()) {
            return '';
        }
        return '/'.$this->getSeoImgFolder(). $this->getSeoImage();
    }

    public function getCardImage(): ?string
    {
        return $this->cardImage;
    }

    public function setCardImage(?string $cardImage): self
    {
        $this->cardImage = $cardImage;

        return $this;
    }
    
    public function getCardImageUrl():string
    {
        if ( ! $this->getCardImage()) {
            return '';
        }
        return '/'.$this->getCardImgFolder(). $this->getCardImage();
    }

    public function getCardDescription(): ?string
    {
        return $this->cardDescription;
    }

    public function setCardDescription(?string $cardDescription): self
    {
        $this->cardDescription = $cardDescription;

        return $this;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function changeModifyDate()
    {
        $this->modified_at = new DateTimeImmutable();
    }
    
    public function getH1(): string
    {
        return $this->getName();
    }
    
    public function getCardHeader(): string
    {
        return $this->getName().' цена';
    }
    
    public function getTextComputed(): string
    {
        return str_replace(['<p>', '</p>', '<span>', '</span>'], ['<ul>', '</ul>', '<li>', '</li>'],
            (string)$this->getCardDescription());
    }
    
    public function getModifyDate(): ?DateTimeInterface
    {
        return $this->getModifiedAt();
    }
    
    /**
     * @return bool
     */
    public function isYml(): bool
    {
        return $this->yml;
    }
    
    /**
     * @param bool $yml
     *
     * @return $this
     */
    public function setYml(bool $yml): self
    {
        $this->yml = $yml;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isTurbo(): bool
    {
        return $this->turbo;
    }
    
    /**
     * @param bool $turbo
     *
     * @return $this
     */
    public function setTurbo(bool $turbo): self
    {
        $this->turbo = $turbo;
        
        return $this;
    }
    
    public function getUnits(): string
    {
        return 'руб/м2';
    }
}
