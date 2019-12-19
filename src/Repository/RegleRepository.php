<?php

namespace App\Repository;

use App\Entity\Regle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Regle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regle[]    findAll()
 * @method Regle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regle::class);
    }

     /**
      * @return Regle[] Returns an array of Regle objects
      */

    public function findByGE($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.ge = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Regle
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
