<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }
    
    /**
     * @return Page[] Returns an array of Page objects
     */
    public function findLike(string $field, string $value): array
    {
        return $this->createQueryBuilder('p')
                    ->andWhere(sprintf('p.%s LIKE :val', $field))
                    ->setParameter('val', $value)
                    ->orderBy('p.id', 'ASC')
                    ->getQuery()
                    ->getResult();
    }
    
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMaxOrdering(Page $parent): int
    {
        return $this->createQueryBuilder('p')
                    ->select('MAX(p.ordering)')
                    ->andWhere('p.parent = :parent')
                    ->setParameter('parent', $parent)
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    
    // /**
    //  * @return Page[] Returns an array of Page objects
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
    public function findOneBySomeField($value): ?Page
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
