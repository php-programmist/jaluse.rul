<?php

namespace App\Service;

use App\Dto\BreadcrumbItemDto;
use App\Entity\Page;

class BreadcrumbsService
{
    /**
     * @param Page $content
     *
     * @return BreadcrumbItemDto[]|null
     */
    public function getItems(Page $content): ?array
    {
        if (!$this->supports($content)) {
            return null;
        }
        $chain = $this->getChain($content);
        
        return $this->getItemList($chain);
    }
    
    /**
     * @param Page $content
     *
     * @return Page[]
     */
    private function getChain(Page $content): array
    {
        $pages = [];
        
        $pages[] = $content;
        
        if (!$content->getParent() || $content->getParent()->getId() === 1) {
            return $pages;
        }
        $parent = $content->getParent();
        
        return array_merge($this->getChain($parent), $pages);
    }
    
    /**
     * @param Page[] $chain
     *
     * @return BreadcrumbItemDto[]
     */
    private function getItemList(array $chain): array
    {
        $itemList   = [];
        $itemList[] = new BreadcrumbItemDto('Главная', '/');
        foreach ($chain as $item) {
            if ($item instanceof Page) {
                $itemList[] = new BreadcrumbItemDto($item->getName(), $item->getPath());
            }
        }
        
        return $itemList;
    }
    
    private function supports($content): bool
    {
        return $content instanceof Page;
    }
}