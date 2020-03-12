<?php

namespace App\Repository;

use App\Entity\ActiviteProtoPosteTravailProto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActiviteProtoPosteTravailProto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActiviteProtoPosteTravailProto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActiviteProtoPosteTravailProto[]    findAll()
 * @method ActiviteProtoPosteTravailProto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteProtoPosteTravailProtoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActiviteProtoPosteTravailProto::class);
    }

    // /**
    //  * @return ActiviteProtoPosteTravailProto[] Returns an array of ActiviteProtoPosteTravailProto objects
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
    public function findOneBySomeField($value): ?ActiviteProtoPosteTravailProto
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
