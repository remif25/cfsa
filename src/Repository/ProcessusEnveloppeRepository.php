<?php

namespace App\Repository;

use App\Entity\ProcessusEnveloppe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProcessusEnveloppe|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessusEnveloppe|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessusEnveloppe[]    findAll()
 * @method ProcessusEnveloppe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessusEnveloppeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcessusEnveloppe::class);
    }

    // /**
    //  * @return ProcessusEnveloppe[] Returns an array of ProcessusEnveloppe objects
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
    public function findOneBySomeField($value): ?ProcessusEnveloppe
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
