<?php

namespace App\Repository;

use App\Entity\RentRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentRow[]    findAll()
 * @method RentRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentRow::class);
    }

    // /**
    //  * @return RentRow[] Returns an array of RentRow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentRow
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
