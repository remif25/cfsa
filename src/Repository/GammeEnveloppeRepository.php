<?php

namespace App\Repository;

use App\Entity\GammeEnveloppe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GammeEnveloppe|null find($id, $lockMode = null, $lockVersion = null)
 * @method GammeEnveloppe|null findOneBy(array $criteria, array $orderBy = null)
 * @method GammeEnveloppe[]    findAll()
 * @method GammeEnveloppe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GammeEnveloppeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GammeEnveloppe::class);
    }

    // /**
    //  * @return GammeEnveloppe[] Returns an array of GammeEnveloppe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySlug($value): ?GammeEnveloppe
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.slug = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
