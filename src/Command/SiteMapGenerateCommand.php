<?php

namespace App\Command;

use App\Service\SiteMapService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SiteMapGenerateCommand extends Command
{
    public function __construct(
        private SiteMapService $siteMapService,
        string $name = null
    ) {
        parent::__construct($name);
    }
    
    protected static $defaultName = 'app:sitemap:generate';
    
    protected function configure()
    {
        $this->setDescription('Генерирует Sitemap');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io    = new SymfonyStyle($input, $output);
        $start = time();
        $this->siteMapService->generate();
        $io->success(sprintf('Generated for %d seconds', time() - $start));
        
        return 0;
    }
    
}
