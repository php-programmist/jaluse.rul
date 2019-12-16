<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;

class ExtraFieldsFixtures extends Fixture
{
    /**
     * @var Connection
     */
    protected $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    public function load(ObjectManager $manager)
    {
        $colors = $this->connection->createQueryBuilder()
                                        ->select('id,pagetitle,longtitle,alias')
                                        ->from('modx_site_content')
                                        ->andWhere('parent=82')
                                        ->execute()
                                        ->fetchAll(\PDO::FETCH_OBJ);
        foreach ($colors as $color) {
            $values = [
                'id'=>$color->id,
                'name'=> $this->connection->quote($color->pagetitle),
                'alias'=> $this->connection->quote($color->alias),
                'hex'=> $this->connection->quote($color->longtitle),
            ];
            $query = $this->connection->createQueryBuilder()
                                      ->insert('color')
                                      ->values($values);
            $query->execute();
        }
    
        $types = $this->connection->createQueryBuilder()
                                        ->select('id,pagetitle')
                                        ->from('modx_site_content')
                                        ->andWhere('parent=83')
                                        ->execute()
                                        ->fetchAll(\PDO::FETCH_OBJ);
        foreach ($types as $type) {
            $values = [
                'id'=>$type->id,
                'name'=> $this->connection->quote($type->pagetitle)
            ];
            $query = $this->connection->createQueryBuilder()
                                      ->insert('type')
                                      ->values($values);
            $query->execute();
        }
    
        $materials = $this->connection->createQueryBuilder()
                                        ->select('id,pagetitle')
                                        ->from('modx_site_content')
                                        ->andWhere('parent=85')
                                        ->execute()
                                        ->fetchAll(\PDO::FETCH_OBJ);
        foreach ($materials as $material) {
            $values = [
                'id'=>$material->id,
                'name'=> $this->connection->quote($material->pagetitle)
            ];
            $query = $this->connection->createQueryBuilder()
                                      ->insert('material')
                                      ->values($values);
            $query->execute();
        }
    }
}
