<?php

namespace App\Repository;

use App\Entity\Markiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Markiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Markiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Markiz[]    findAll()
 * @method Markiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarkizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Markiz::class);
    }

    // /**
    //  * @return Markiz[] Returns an array of Markiz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Markiz
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
