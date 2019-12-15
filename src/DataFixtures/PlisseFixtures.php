<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PlisseFixtures extends Fixture
{
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * @var ParameterBagInterface
     */
    protected $params;
    
    public function __construct(Connection $connection,ParameterBagInterface $params)
    {
        
        $this->connection = $connection;
        $this->params = $params;
    }
    
    public function load(ObjectManager $manager)
    {
        $project_dir = $this->params->get('kernel.project_dir');
        $fh = fopen($project_dir.'/csv/plisse.csv','r');
        while ($row = fgetcsv($fh,8000,';')){
            [$id,$uri,$price,$category,$popular,$published] = $row;
            $this->updateProduct($id,$price,$category,$popular,$published);
        }
    }
    
    private function updateProduct($id, $price, $category, $popular, $published)
    {
        $this->connection->createQueryBuilder()
                         ->update('page')
                         ->set('price',$price)
                         ->set('popular',$popular)
                         ->set('published',$published)
                         ->set('category_id',$category)
                         ->set('type_id',175)
                         ->andWhere('id = '.$id)
                         ->execute();
    }
}
