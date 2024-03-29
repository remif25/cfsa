<?php

namespace App\Repository;

use App\Entity\PosteTravailProto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PosteTravailProto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosteTravailProto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosteTravailProto[]    findAll()
 * @method PosteTravailProto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteTravailProtoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosteTravailProto::class);
    }

    // /**
    //  * @return PosteTravailProto[] Returns an array of PosteTravailProto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneByReference($value): ?PosteTravailProto
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.reference = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
