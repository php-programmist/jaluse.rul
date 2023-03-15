<?php

namespace App\Entity;

use App\Entity\Contracts\HasExamplesInterface;
use App\Entity\Contracts\TurboPageInterface;
use App\Entity\Traits\RatingTrait;
use App\Model\GeoProduct\RulonnyieShtoryiGeoProduct;
use App\Model\GeoProduct\ZhalyuziGeoProduct;
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
 *     Geo::TYPE = "Geo",
 *     Calculator::TYPE = "Calculator",
 *     Article::TYPE = "Article",
 * })
 * @ORM\Table(indexes={
 *     @ORM\Index(name="IDX_NAME_FULLTEXT", columns={"name"}, flags={"fulltext"})
 * })
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Page implements TurboPageInterface, HasExamplesInterface
{
    use RatingTrait;
    
    const MIN_RATING_VALUE = 4.7;
    const MAX_RATING_VALUE = 4.9;
    const MIN_RATING_COUNT = 8;
    const MAX_RATING_COUNT = 35;
    const DEFAULT_WORK_EXAMPLES_LIMIT = 3;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected ?string $name = '';
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $h1 = null;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $nameGenitive = null;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected ?string $nameNominative = null;
    
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
    protected $published = 1;
    
    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $yml = false;
    
    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $turbo = false;
    
    /**
     * @ORM\Column(type="boolean", options={"default": 1})
     */
    protected $showSeoText = true;
    
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
    
    /**
     * @var string
     * @ORM\Column(type="string",options={"default": App\Model\GeoProduct\ZhalyuziGeoProduct::TYPE})
     */
    protected $geoProductType = ZhalyuziGeoProduct::TYPE;
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected ?array $popularCategories = [];
    
    /**
     * @ORM\ManyToMany(targetEntity=WorkExample::class, mappedBy="pages")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private Collection $workExamplesOfPage;
    
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected ?array $settings = [];
    
    /**
     * @ORM\Column(type="integer",nullable=false, options={"default": 0})
     */
    protected int $ordering = 0;
    
    public function __construct()
    {
        $this->created_at  = new DateTimeImmutable();
        $this->modified_at = new DateTimeImmutable();
        $this->pages       = new ArrayCollection();
        $this->generateRatingAndCount();
        $this->workExamplesOfPage = new ArrayCollection();
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
        if ($this->uri === '/') {
            return '/';
        }
        
        return '/' . $this->uri . '/';
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
        return $this->pages ?? new ArrayCollection();
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
    
    public function getSeoFirstPart(): string
    {
        if (empty($this->getContent())) {
            return '';
        }
        $parts = preg_split('#<hr.*?>#', $this->getContent(), 2);
        
        return $parts[0];
    }
    
    public function getSeoSecondPart(): string
    {
        if (empty($this->getContent())) {
            return '';
        }
        $parts = preg_split('#<hr.*?>#', $this->getContent(), 2);
        
        return $parts[1] ?? '';
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
        if (!$this->getSeoImage()) {
            return '';
        }
        
        return '/' . $this->getSeoImgFolder() . $this->getSeoImage();
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
    
    public function getCardImageUrl(): string
    {
        if (!$this->getCardImage()) {
            return '';
        }
        
        return '/' . $this->getCardImgFolder() . $this->getCardImage();
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
        return !empty($this->h1) ? $this->h1 : $this->getName();
    }
    
    public function setH1(?string $h1): self
    {
        $this->h1 = $h1;
        
        return $this;
    }
    
    public function getCardHeader(): string
    {
        return $this->getName() . ' цена';
    }
    
    public function getTextComputed(): string
    {
        return str_replace(['<p>', '</p>', '<span>', '</span>', '<b>', '</b>'],
            ['<div>', '</div>', '', '<br />' . PHP_EOL, '<strong>', '</strong>'],
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
    
    /**
     * @return string
     */
    public function getGeoProductType(): string
    {
        return $this->geoProductType;
    }
    
    public function getGeoProductCalculatorSelectedType(): ?int
    {
        return $this->getGeoProductType() === RulonnyieShtoryiGeoProduct::TYPE ? 133 : null;
    }
    
    public function getBaseCatalogUri(): string
    {
        return $this->getGeoProductType() === RulonnyieShtoryiGeoProduct::TYPE ? 'rulonnyie-shtoryi' : 'zhalyuzi';
    }
    
    public function getPriceFormat(): string
    {
        return $this->getGeoProductType() === RulonnyieShtoryiGeoProduct::TYPE ? 'от %d рублей за изделие' : 'от %d руб/м2';
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
    
    /**
     * @return bool
     */
    public function isShowSeoText(): bool
    {
        return $this->showSeoText;
    }
    
    /**
     * @param bool $showSeoText
     *
     * @return $this
     */
    public function setShowSeoText(bool $showSeoText): self
    {
        $this->showSeoText = $showSeoText;
        
        return $this;
    }
    
    public function getTurboContentTemplate(): string
    {
        return 'turbo/content.html.twig';
    }
    
    public function getCalcLink(): ?string
    {
        return '/zhalyuzi/kalkulyator/';
    }
    
    /**
     * @return Collection|WorkExample[]
     */
    public function getWorkExamplesOfPage(): Collection
    {
        return $this->workExamplesOfPage;
    }
    
    public function getWorkExamplesLimit(): int
    {
        return $this->getSetting('work_examples_limit') ?? self::DEFAULT_WORK_EXAMPLES_LIMIT;
    }
    
    public function addWorkExamplesOfPage(WorkExample $workExamplesOfPage): self
    {
        if (!$this->workExamplesOfPage->contains($workExamplesOfPage)) {
            $this->workExamplesOfPage[] = $workExamplesOfPage;
            $workExamplesOfPage->addPage($this);
        }
        
        return $this;
    }
    
    public function removeWorkExamplesOfPage(WorkExample $workExamplesOfPage): self
    {
        if ($this->workExamplesOfPage->removeElement($workExamplesOfPage)) {
            $workExamplesOfPage->removePage($this);
        }
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getNameGenitive(): ?string
    {
        return $this->nameGenitive ?? $this->name;
    }
    
    /**
     * @param string|null $nameGenitive
     *
     * @return $this
     */
    public function setNameGenitive(?string $nameGenitive): self
    {
        $this->nameGenitive = $nameGenitive;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getNameNominative(): ?string
    {
        return $this->nameNominative ?? $this->name;
    }
    
    /**
     * @param string|null $nameNominative
     *
     * @return $this
     */
    public function setNameNominative(?string $nameNominative): self
    {
        $this->nameNominative = $nameNominative;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getPopularCategories(): array
    {
        return $this->popularCategories ?? [];
    }
    
    /**
     * @param array|null $popularCategories
     *
     * @return Catalog
     */
    public function setPopularCategories(?array $popularCategories): self
    {
        $this->popularCategories = $popularCategories;
        
        return $this;
    }
    
    public function getLocationsCatalog(): ?Catalog
    {
        $catalog = $this->getPages()
                        ->filter(
                            fn(Page $page) => $page instanceof Catalog
                                              && $page->isLocationsCatalog()
                        );
        
        return $catalog->isEmpty() ? null : $catalog->first();
    }
    
    public function getImageAlt(): string
    {
        return sprintf('%s цена. Купить в «Мастерская Жалюзи»', $this->getName() ?? '');
    }
    
    public function getImageTitle(): string
    {
        return $this->getName() ?? '';
    }
    
    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings ?? [];
    }
    
    public function getSetting(string $name): mixed
    {
        return $this->getSettings()[$name] ?? null;
    }
    
    /**
     * @param array|null $settings
     *
     * @return $this
     */
    public function setSettings(?array $settings): self
    {
        $this->settings = $settings;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getOrdering(): int
    {
        return $this->ordering;
    }
    
    /**
     * @param int $ordering
     *
     * @return $this
     */
    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;
        
        return $this;
    }
}
