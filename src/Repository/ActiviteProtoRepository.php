<?php

namespace App\Repository;

use App\Entity\ActiviteProto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActiviteProto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActiviteProto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActiviteProto[]    findAll()
 * @method ActiviteProto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteProtoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActiviteProto::class);
    }

    // /**
    //  * @return ActiviteProto[] Returns an array of ActiviteProto objects
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
    public function findOneBySomeField($value): ?ActiviteProto
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
