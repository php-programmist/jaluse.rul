<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="page_type", type="string")
 * @Vich\Uploadable
 */
class Page
{
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
    
    
    
    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->modified_at = new \DateTimeImmutable();
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

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function getPath(): ?string
    {
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at)
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
        return $this->getName();
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
            $this->modified_at = new \DateTime('now');
        }
    }
    
    public function getSeoImageFile()
    {
        return $this->seoImageFile;
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
}
