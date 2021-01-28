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
     * @param array $filters
     * @param int   $offset
     * @param int   $limit
     *
     * @return Product[] Returns an array of Product objects
     */
    public function findFiltered($filters = [], $offset = 0, $limit = 0)
    {
        $query = $this->getFilteredQB($filters);
        if ($limit) {
            $query->setMaxResults($limit);
        }
        if ($offset) {
            $query->setFirstResult($offset);
        }
        
        return $query->getQuery()
                     ->getResult();
    }
    
    public function countFiltered(array $filters = []): int
    {
        $query = $this->getFilteredQB($filters);
        
        return $query->select('count(p.id)')
                     ->getQuery()
                     ->getSingleScalarResult();
    }
    
    public function getPopular($filters = [],$limit=0)
    {
        $query               = $this->getFilteredQB($filters);
        $query->andWhere('p.popular = true')
            ->orderBy('p.price', 'DESC')
            ->addOrderBy('p.matrix_id', 'DESC')
        ;
        if ($limit) {
            $query->setMaxResults($limit);
        }
        return $query->getQuery()
                     ->getResult();
    }
    
    /**
     * @param array $filters
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getFilteredQB($filters = [])
    {
        $query = $this->createQueryBuilder('p')
                      ->leftJoin('p.type', 't')
                      ->leftJoin('p.parent', 'p2')
                      ->addSelect('p2')
                      ->andWhere('t.show_main_page_calc = 1')
                      ->andWhere('p.price IS NOT NULL OR p.matrix_id IS NOT NULL')
                      ->addOrderBy('p.price', 'ASC')
                      ->addOrderBy('p.matrix_id', 'ASC');
        
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
                  ->setParameter('color', explode(',', $filters['color']));
        }
        
        return $query;
    }
    
    public function getAvailableColors($filters = [])
    {
        $query = $this->createQueryBuilder('p')
                      ->leftJoin('p.type', 't')
                      ->innerJoin('p.color', 'c')
                      ->select('c.id')
                      ->andWhere('t.show_main_page_calc = 1');
        
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
        $ids    = array_map('current', $result);
        
        return array_filter($ids);
    }
    
    public function getPopularSiblings(Product $product, $limit=0)
    {
        $filters             = [];
        $filters['type']     = $product->getType() ? $product->getType()->getId() : null;
        $filters['material'] = $product->getMaterial() ? $product->getMaterial()->getId() : null;
        $filters['category'] = $product->getCategory() ? $product->getCategory()->getId() : null;
        $query               = $this->getFilteredQB($filters);
        $query->orderBy('p.popular','DESC');
        if ($limit) {
            $query->setMaxResults($limit);
        }
        return $query->getQuery()
                     ->getResult();
    }
    /**
     * @return Product[] Returns an array of Product objects
     */
    public function getAllActive():array
    {
        return $this->createQueryBuilder('p')
                    ->andWhere('p.published = 1')
                    ->andWhere('p.price is not null or p.category is not null')
                    ->orderBy('p.id', 'ASC')
                    ->getQuery()
                    ->getResult()
            ;
    }
    
    /**
     * @return Product[] Returns an array of Product objects
     */
    public function getForYml():array
    {
        return $this->createQueryBuilder('p')
                    ->andWhere('p.published = 1')
                    ->andWhere('p.yml = 1')
                    ->andWhere('p.price is not null or p.category is not null')
                    ->orderBy('p.id', 'ASC')
                    ->getQuery()
                    ->getResult()
            ;
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
