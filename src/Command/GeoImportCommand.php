<?php

namespace App\Command;

use App\Entity\City;
use App\Entity\District;
use App\Entity\Metro;
use App\Entity\Region;
use App\Helper\SlugHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GeoImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var string
     */
    private $projectDir;
    
    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $projectDir
     * @param string|null            $name The name of the command; passing null means it must be set in configure()
     *
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $projectDir,
        string $name = null
    ) {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->projectDir    = $projectDir;
    }
    
    protected static $defaultName = 'app:geo:import';
    
    protected function configure()
    {
        $this->setDescription('Импортирует данные из geo.csv');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io     = new SymfonyStyle($input, $output);
        $fh     = fopen($this->projectDir . '/csv/geo.csv', 'rb');
        $parent = null;
        while ($row = fgetcsv($fh, 0, ';')) {
            $row = array_map('trim', $row);
            if ('' !== $row[0]) {
                $parent = $this->createRegion($row[0]);
            }
            if ('' !== $row[1]) {
                $this->createChild(City::class, $row[1], $parent);
            }
            if ('' !== $row[2]) {
                $this->createChild(District::class, $row[2], $parent);
            }
            if ('' !== $row[3]) {
                $this->createChild(Metro::class, $row[3], $parent);
            }
        }
        $this->entityManager->flush();
        $io->success('Data imported');
        
        return 0;
    }
    
    private function createRegion(string $name): Region
    {
        $region = (new Region())
            ->setName($name)
            ->setUri(SlugHelper::makeSlug($name))
            ->setTurbo(true);
        $this->entityManager->persist($region);
        
        return $region;
    }
    
    private function createChild(string $class, string $name, Region $parent): void
    {
        $uri   = sprintf('%s/%s', $parent->getUri(), SlugHelper::makeSlug($name));
        $child = (new $class())
            ->setName($name)
            ->setUri($uri)
            ->setParent($parent)
            ->setTurbo(true);
        $this->entityManager->persist($child);
    }
}
