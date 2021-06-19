<?php

namespace App\Service;

use App\Entity\Catalog;
use App\Entity\Product;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class CatalogManager
{
    private EntityManagerInterface $entityManager;
    
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
    public function getPopular(Catalog $catalog, int $limit = 0): array
    {
        $filters             = [];
        $filters['category'] = 1;
        if ($catalog->getType()) {
            $filters['type'] = $catalog->getType()->getId();
        } else {
            $filters['type'] = 178; //isolite
        }
        if ($catalog->getMaterial()) {
            $filters['material'] = $catalog->getMaterial()->getId();
        }
        
        return $this->entityManager
            ->getRepository(Product::class)
            ->getPopular($filters, $limit);
    }
    
    /**
     * @param Catalog $catalog
     * @param string  $orderBy
     * @param string  $orderDir
     *
     * @return Query
     */
    public function getProductsQuery(Catalog $catalog, string $orderBy, string $orderDir): Query
    {
        $filters = [];
        if ($catalog->getType()) {
            $filters['type'] = $catalog->getType()->getId();
        } else {
            $filters['type'] = 178; //isolite
        }
        if ($catalog->getMaterial()) {
            $filters['material'] = $catalog->getMaterial()->getId();
        }
        
        return $this->entityManager
            ->getRepository(Product::class)
            ->getProductsQB($filters, $orderBy, $orderDir)
            ->getQuery();
    }
    
    public function getCatalogsLinks(Catalog $catalog): array
    {
        $type     = $catalog->getType();
        $material = $catalog->getMaterial();
        $allTypes = $this->entityManager->getRepository(Type::class)->findBy([], ['id' => 'asc']);
        $links    = [];
        if (null === $material) {
            //Один из каталогов верхнего уровня.
            if (null === $type || $type->getMaterials()->isEmpty()) {
                //Подтипы отсутствуют - показываем соседние каталоги с типами
                /** @var Type $type */
                foreach ($allTypes as $type) {
                    if (!$type->getCatalogs()->isEmpty()) {
                        foreach ($type->getCatalogs() as $siblingCatalog) {
                            if (null === $siblingCatalog->getMaterial()) {
                                $links[$type->getName()] = $siblingCatalog->getPath();
                            }
                        }
                    }
                }
            } else {
                //Есть подтипы - показываем каталоги подтипов
                $links = $this->getMaterialLinks($type, $catalog, $links);
            }
            
        } else {
            //Это подтип
            $links = $this->getMaterialLinks($type, $catalog, $links);
            
        }
        
        return $links;
    }
    
    /**
     * @param Type    $type
     * @param Catalog $catalog
     * @param array   $links
     *
     * @return array
     */
    private function getMaterialLinks(Type $type, Catalog $catalog, array $links): array
    {
        foreach ($type->getMaterials() as $siblingMaterial) {
            $catalogs = $siblingMaterial->getCatalogs();
            if (count($catalogs) > 1 && null !== $catalog->getType()) {
                foreach ($catalogs as $siblingCatalog) {
                    if ($catalog->getType()->getId() === $type->getId()) {
                        $links[$siblingMaterial->getName()] = $siblingCatalog->getPath();
                    }
                }
            } else {
                $links[$siblingMaterial->getName()] = $siblingMaterial->getCatalogs()->first()->getPath();
            }
            
        }
        
        return $links;
    }
}