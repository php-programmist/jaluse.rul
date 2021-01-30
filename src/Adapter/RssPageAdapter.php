<?php

namespace App\Adapter;

use App\Entity\Contracts\TurboPageInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\BasePageInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\RssAdapterInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\RssItem;
use Twig\Environment;

class RssPageAdapter implements RssAdapterInterface
{
    /**
     * @var RssItem[]
     */
    protected $items;
    /**
     * @var BasePageInterface
     */
    protected $basePage;
    /**
     * @var Environment
     */
    protected $twig;
    protected $originalItems;

    /**
     * @param Environment $twig
     */
    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    /**
     * @return RssItem[]
     */
    public function getItems(): array
    {
        if (empty($this->items)) {
            $this->adapt();
        }
        return $this->items;
    }

    protected function adapt(): void
    {
        /** @var TurboPageInterface $originalItem */
        foreach ($this->originalItems as $originalItem) {
            $link = $originalItem->getPath();
            $item = new RssItem(
                $originalItem->getId(),
                $link,
                strip_tags($originalItem->getH1()),
                $originalItem->getModifyDate()->getTimestamp(),
                $this->getText($originalItem)
            );
            $item->setAllBreadcrumbs('Жалюзи', $this->basePage);
            $this->addItem($item);
        }
    }

    protected function getText(TurboPageInterface $page): string
    {
        
        return $this->twig->render('turbo/content.html.twig', [
            'page' => $page,
        ]);
    }

    protected function addItem(RssItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param TurboPageInterface[]|array
     * @return $this
     */
    public function setOriginalItems(array $originalItems): self
    {
        $this->originalItems = $originalItems;
        return $this;
    }

    /**
     * @param BasePageInterface $basePage
     * @return $this
     */
    public function setBasePage(BasePageInterface $basePage): self
    {
        $this->basePage = $basePage;
        return $this;
    }
}