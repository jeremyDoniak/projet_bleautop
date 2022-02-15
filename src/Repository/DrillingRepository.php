<?php

namespace App\Repository;

use App\Entity\Drilling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Drilling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drilling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drilling[]    findAll()
 * @method Drilling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrillingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drilling::class);
    }

    // /**
    //  * @return Drilling[] Returns an array of Drilling objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Drilling
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
