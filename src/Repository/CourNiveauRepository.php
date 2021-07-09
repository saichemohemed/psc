<?php

namespace App\Repository;

use App\Entity\CourNiveau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourNiveau|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourNiveau|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourNiveau[]    findAll()
 * @method CourNiveau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourNiveauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourNiveau::class);
    }

    // /**
    //  * @return CourNiveau[] Returns an array of CourNiveau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourNiveau
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
