<?php

namespace App\Repository;

use App\Entity\CourSoutien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourSoutien|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourSoutien|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourSoutien[]    findAll()
 * @method CourSoutien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourSoutienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourSoutien::class);
    }

    // /**
    //  * @return CourSoutien[] Returns an array of CourSoutien objects
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
    public function findOneBySomeField($value): ?CourSoutien
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
