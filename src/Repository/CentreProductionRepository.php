<?php

namespace App\Repository;

use App\Entity\CentreProduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CentreProduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentreProduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentreProduction[]    findAll()
 * @method CentreProduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentreProduction::class);
    }

    // /**
    //  * @return CentreProduction[] Returns an array of CentreProduction objects
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


    public function findOneByReference($value): ?CentreProduction
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.reference = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
