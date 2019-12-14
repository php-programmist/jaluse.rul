<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImportFixtures extends Fixture
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
        $fh = fopen($project_dir.'/products.csv','r');
        while ($row = fgetcsv($fh,8000,';')){
            [$uri,$price,$category,$popular,$published] = $row;
            if (!$id = $this->getProductByUri($uri)) {
                continue;
            }
            if ( ! $price) {
                if ( !$price = $this->getPrice($id)){
                    continue;
                }
            }
            $this->updateProduct($id,$price,$category,$popular,$published);
        }
    }
    
    private function getProductByUri($uri)
    {
        $uri = trim($uri,'/');
        return $this->connection->createQueryBuilder()
                                  ->select('id')
                                  ->from('page')
                                  ->andWhere('uri = '.$this->connection->quote($uri))
                                  ->execute()
                                  ->fetchColumn();
    }
    
    private function getPrice($id)
    {
        return $this->connection->createQueryBuilder()
                                ->select('price')
                                ->from('modx_ms2_products')
                                ->andWhere('id = '.$id)
                                ->execute()
                                ->fetchColumn();
    }
    
    private function updateProduct($id, $price, $category, $popular, $published)
    {
        $this->connection->createQueryBuilder()
                         ->update('page')
                         ->set('price',$price)
                         ->set('popular',$popular)
                         ->set('published',$published)
                         ->set('category_id',$category?:1)
                         ->andWhere('id = '.$id)
                         ->execute();
    }
}
