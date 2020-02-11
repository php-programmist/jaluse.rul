<?php

namespace App\Model;

use App\Dto\YmlOfferDto;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class YmlModel
{
    /**
     * @var Connection
     */
    protected $connection;
    
    public function __construct(Connection $connection)
    {
        
        $this->connection = $connection;
    }
    
    /**
     * @return YmlOfferDto[]
     */
    public function getOffers():array
    {
        $query  = $this->connection
            ->createQueryBuilder()
            ->select('c.id,c.path, c.meta_title, c.meta_description,s.hours')
            ->from('`pricelist_services`', 's')
            ->leftJoin('s', 'content', 'c', 'c.name = s.name')
            ->andWhere("c.name IS NOT NULL");
        $result = $query->execute();
        $result->setFetchMode(FetchMode::CUSTOM_OBJECT, YmlOfferDto::class);
        
        return $result->fetchAll();
    }
    
    public function getMainPageData()
    {
        $query  = $this->connection
            ->createQueryBuilder()
            ->select('c.meta_title, c.meta_description')
            ->from('content','c')
            ->andWhere("path = '/'");
        $result = $query->execute();
        $result->setFetchMode(FetchMode::STANDARD_OBJECT);
        return $result->fetch();
    }
    
}