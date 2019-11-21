<?php

namespace App\Repository;

use App\Entity\LinkRegleOperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LinkRegleOperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkRegleOperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkRegleOperation[]    findAll()
 * @method LinkRegleOperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRegleOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkRegleOperation::class);
    }

    // /**
    //  * @return LinkRegleOperation[] Returns an array of LinkRegleOperation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LinkRegleOperation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
