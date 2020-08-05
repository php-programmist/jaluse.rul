<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class CatalogManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @param Catalog $catalog
     * @param int     $limit
     *
     * @return Product[]|array
     */
    public function getPopular(Catalog $catalog,$limit = 0): array
    {
        $filters             = [];
        $filters['category'] = 1;
        if ($catalog->getType()) {
            $filters['type'] = $catalog->getType()->getId();
        }
        if ($catalog->getMaterial()) {
            $filters['material'] = $catalog->getMaterial()->getId();
        }
        return $this->entityManager
            ->getRepository(Product::class)
            ->getPopular($filters,$limit);
    }
}