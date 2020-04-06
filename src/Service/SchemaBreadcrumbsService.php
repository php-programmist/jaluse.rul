<?php

namespace App\Service;

use App\Entity\Page;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SchemaBreadcrumbsService
{
    protected $base_uri;
    
    public function __construct(ParameterBagInterface $params)
    {
        $this->base_uri = $params->get('base_uri');
    }
    
    public function getSchema(Page $content):?array
    {
        if ( ! $this->supports($content)) {
            return null;
        }
        $chain = $this->getChain($content);
        $schema['@context'] = 'http://schema.org';
        $schema['@type'] = 'BreadcrumbList';
        $schema['itemListElement'] = $this->getItemList($chain);
        return $schema;
    }
    
    private function getChain(Page $content)
    {
        $pages=[];
       
        $pages[] = $content;
        
        if ( ! $content->getParent()) {
            return $pages;
        }
        $parent = $content->getParent();
        
        return array_merge($this->getChain($parent), $pages);
    }
    
    /**
     * @param Page[] $chain
     *
     * @return array
     */
    private function getItemList($chain)
    {
        $itemListElement = [];
        foreach ($chain as $index => $item) {
            $element                = [];
            $element['@type']       = 'ListItem';
            $element['position']    = $index + 1;
            if ($item->getId() === 1) {
                $element['item']['name'] = "🚩 Жалюзи Сервис";
                $element['item']['@id'] = $this->base_uri;
            }elseif($item instanceof Page){
                $element['item']['@id'] = $this->base_uri.$item->getPath();
                $element['item']['name'] = $this->getIcon($index).' '.$item->getName();
            }
            $itemListElement[] = $element;
        }
        
        return $itemListElement;
    }
    
    private function supports($content)
    {
        if ($content instanceof Page) {
            return true;
        }
        return false;
    }
    
    private function getIcon($index)
    {
        return $index%2===1?'⭐':'✅';
    }
}