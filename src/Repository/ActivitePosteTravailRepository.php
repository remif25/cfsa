<?php

namespace App\Repository;

use App\Entity\ActivitePosteTravail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActivitePosteTravail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivitePosteTravail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivitePosteTravail[]    findAll()
 * @method ActivitePosteTravail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivitePosteTravailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivitePosteTravail::class);
    }

    // /**
    //  * @return ActivitePosteTravail[] Returns an array of ActivitePosteTravail objects
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
    public function findOneBySomeField($value): ?ActivitePosteTravail
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
