<?php

namespace App\Repository;

use App\Entity\Subdomain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subdomain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subdomain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subdomain[]    findAll()
 * @method Subdomain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubdomainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subdomain::class);
    }
    
    // /**
    //  * @return Subdomain[] Returns an array of Subdomain objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    
    /*
    public function findOneBySomeField($value): ?Subdomain
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
