<?php

namespace App\Repository;

use App\Entity\ArrierePlanAccueil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArrierePlanAccueil|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArrierePlanAccueil|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrierePlanAccueil[]    findAll()
 * @method ArrierePlanAccueil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrierePlanAcceuilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArrierePlanAccueil::class);
    }

    // /**
    //  * @return ArrierePlanAccueil[] Returns an array of ArrierePlanAccueil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArrierePlanAccueil
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
