<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    
    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findFiltered($products_limit, $filters = [])
    {
        $query = $this->createQueryBuilder('p')
                      ->leftJoin('p.type', 't')
                      ->leftJoin('p.parent', 'p2')
                      ->addSelect('p2')
                      ->andWhere('t.show_main_page_calc = 1')
                      ->andWhere('p.price IS NOT NULL OR p.matrix_id IS NOT NULL')
                      ->orderBy('p.popular', 'DESC');
        
        if ( ! empty($filters['category'])) {
            $query->andWhere('p.category = :category')
                  ->setParameter('category', $filters['category']);
        } else {
            $query->andWhere('p.category = 1');
        }
    
        if ( ! empty($filters['type'])) {
            $query->andWhere('p.type = :type')
                  ->setParameter('type', $filters['type']);
        }
    
        if ( ! empty($filters['material'])) {
            $query->andWhere('p.material = :material')
                  ->setParameter('material', $filters['material']);
        }
    
        if ( ! empty($filters['color'])) {
            $query->andWhere('p.color IN(:color)')
                  ->setParameter('color', explode(',',$filters['color']));
        }
        
        
        return $query->setMaxResults($products_limit)
                     ->getQuery()
                     ->getResult();
    }
    
    public function getAvailableColors($filters = [])
    {
        $query = $this->createQueryBuilder('p')
                      ->leftJoin('p.type', 't')
                      ->innerJoin('p.color', 'c')
                      ->select('c.id')
                      ->andWhere('t.show_main_page_calc = 1')
        ;
    
        if ( ! empty($filters['category'])) {
            $query->andWhere('p.category = :category')
                  ->setParameter('category', $filters['category']);
        } else {
            $query->andWhere('p.category = 1');
        }
    
        if ( ! empty($filters['type'])) {
            $query->andWhere('p.type = :type')
                  ->setParameter('type', $filters['type']);
        }
    
        if ( ! empty($filters['material'])) {
            $query->andWhere('p.material = :material')
                  ->setParameter('material', $filters['material']);
        }
    
        $result = $query->distinct()
                     ->getQuery()
                     ->getScalarResult();
        $ids = array_map('current', $result);
        return array_filter($ids);
    }
    
    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    
    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
