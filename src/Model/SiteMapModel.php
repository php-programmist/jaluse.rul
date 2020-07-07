<?php

namespace App\Model;

use App\Dto\PageDto;
use App\Repository\PageRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SiteMapModel
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;
    /**
     * @var PageDto[]
     */
    private $pages = [];
    /**
     * @var PageRepository
     */
    protected $page_repository;
    
    protected $reviews_repository;
    
    public function __construct(
        PageRepository $page_repository,
        UrlGeneratorInterface $urlGenerator
    ) {
        
        $this->page_repository = $page_repository;
        $this->urlGenerator    = $urlGenerator;
    }
    
    /**
     * @return PageDto[]
     */
    public function getPages()
    {
        $this->addContentPages();
        
        return $this->pages;
    }
    
    private function addContentPages()
    {
        $pages    = $this->page_repository->findBy(['published'=>true], ['id' => 'asc']);
        $excluded = ['/404/'];
        foreach ($pages as $page) {
            if (in_array($page->getPath(), $excluded, true)) {
                continue;
            }
            $this->pages[] = new PageDto($page->getPath(), $page->getModifiedAt());
        }
    }
    
}