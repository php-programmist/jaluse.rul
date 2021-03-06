<?php

namespace App\Command;

use App\Entity\City;
use App\Entity\District;
use App\Entity\Geo;
use App\Entity\Metro;
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
                $parent = $this->createGeo(District::class, $row[0], null);
            }
            if ('' !== $row[1]) {
                $this->createGeo(City::class, $row[1], $parent);
            }
            if ('' !== $row[2]) {
                $this->createGeo(District::class, $row[2], $parent);
            }
            if ('' !== $row[3]) {
                $this->createGeo(Metro::class, $row[3], $parent);
            }
        }
        $this->entityManager->flush();
        $io->success('Data imported');
        
        return 0;
    }
    
    private function createGeo(string $class, string $name, ?Geo $parent): Geo
    {
        $uri = '';
        if (null !== $parent) {
            $uri = $parent->getUri() . '/';
        }
        $uri .= SlugHelper::makeSlug($name);
        $geo = (new $class())
            ->setName($name)
            ->setUri($uri)
            ->setParent($parent)
            ->setTurbo(true);
        $this->entityManager->persist($geo);
        
        return $geo;
    }
}
