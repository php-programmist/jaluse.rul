<?php

namespace App\Service;

class RobotsTxtService
{
    public function __construct(
        private SubDomainService $subDomainService,
        private string $projectDir,
        private string $baseHost,
    ) {
    }
    
    public function show(): string
    {
        $robotsTxt = file_get_contents($this->getRobotsTxtPath());
        if ($this->subDomainService->isMainDomain()) {
            return $robotsTxt;
        }
        
        return str_replace($this->baseHost, $this->subDomainService->getHost(), $robotsTxt);
    }
    
    private function getRobotsTxtPath(): string
    {
        return $this->projectDir . '/public_html/robots-source.txt';
    }
}