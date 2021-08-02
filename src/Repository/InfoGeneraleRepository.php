<?php

namespace App\Repository;

use App\Entity\InfoGenerale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoGenerale|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoGenerale|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoGenerale[]    findAll()
 * @method InfoGenerale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoGeneraleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoGenerale::class);
    }

    // /**
    //  * @return InfoGenerale[] Returns an array of InfoGenerale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoGenerale
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
