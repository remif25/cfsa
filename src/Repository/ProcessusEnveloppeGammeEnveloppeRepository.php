<?php

namespace App\Repository;

use App\Entity\ProcessusEnveloppeGammeEnveloppe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProcessusEnveloppeGammeEnveloppe|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessusEnveloppeGammeEnveloppe|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessusEnveloppeGammeEnveloppe[]    findAll()
 * @method ProcessusEnveloppeGammeEnveloppe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessusEnveloppeGammeEnveloppeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcessusEnveloppeGammeEnveloppe::class);
    }

    // /**
    //  * @return ProcessusEnveloppeGammeEnveloppe[] Returns an array of ProcessusEnveloppeGammeEnveloppe objects
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

    /*
    public function findOneBySomeField($value): ?ProcessusEnveloppeGammeEnveloppe
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
