<?php

namespace App\Service;

use App\Dto\PageDto;
use App\Repository\PageRepository;
use Twig\Environment;

class SiteMapService
{
    public function __construct(
        private PageRepository $pageRepository,
        private Environment $twig,
        private SubDomainService $subDomainService,
        private string $projectDir,
        private string $baseHost,
    ) {
    }
    
    public function generate(): void
    {
        $siteMap = $this->twig->render('sitemap/index.xml.twig', [
            'pages'    => $this->getPages(),
            'host'     => $this->baseHost,
            'modified' => (new \DateTimeImmutable())->format('Y-m-d\\TH:i:sP'),
        ]);
        
        file_put_contents($this->getSiteMapPath(), $siteMap);
    }
    
    public function show(): string
    {
        $sitemap = file_get_contents($this->getSiteMapPath());
        if ($this->subDomainService->isMainDomain()) {
            return $sitemap;
        }
        
        return str_replace($this->baseHost, $this->subDomainService->getHost(), $sitemap);
    }
    
    /**
     * @return PageDto[]
     */
    private function getPages(): array
    {
        $pages    = $this->pageRepository->findBy(['published' => true], ['id' => 'asc']);
        $excluded = ['/404/'];
        $pagesDto = [];
        foreach ($pages as $page) {
            if (in_array($page->getPath(), $excluded, true)) {
                continue;
            }
            $pagesDto[] = new PageDto($page->getPath(), $page->getPriority());
        }
        
        return $pagesDto;
    }
    
    private function getSiteMapPath(): string
    {
        return $this->projectDir . '/public_html/sitemap-source.xml';
    }
}