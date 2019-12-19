<?php

namespace App\Repository;

use App\Entity\Activite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Activite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activite[]    findAll()
 * @method Activite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activite::class);
    }

    ///**
    //* @return Activite[] Returns an array of Activite objects
    //*/

    /* public function findByPDT($pdt)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $pdt)
            ->leftJoin('p.pdts', 'j')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }*/


    public function findOneByReference($value): ?Activite
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.reference = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
