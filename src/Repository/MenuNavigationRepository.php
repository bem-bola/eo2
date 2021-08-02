<?php

namespace App\Repository;

use App\Entity\MenuNavigation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuNavigation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuNavigation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuNavigation[]    findAll()
 * @method MenuNavigation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuNavigationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuNavigation::class);
    }

    // /**
    //  * @return MenuNavigation[] Returns an array of MenuNavigation objects
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
    public function findOneBySomeField($value): ?MenuNavigation
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
