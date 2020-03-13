<?php

namespace App\Repository;

use App\Entity\Activite;
use App\Entity\ActivitePosteTravail;
use App\Entity\PosteTravail;
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

     /**
      * @return PosteTravail[] Returns an array of PosteTravail objects
      */

    public function findPosteTravailByAvtivite($value)
    {
        $result =  $this->createQueryBuilder('a')
            ->Select('pdt')
            ->from('App:PosteTravail', 'pdt')
            ->andWhere('a.activite = :val')
            ->setParameter('val', $value)
            ->andWhere('pdt = a.posteTravail')
            ->groupBy('pdt.id')
            ->orderBy('pdt.reference', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }


    /**
     * @return Activite[] Returns an array of Activite objects
     */

    public function findActivitebyPosteTravail($value)
    {
        $result =  $this->createQueryBuilder('a')
            ->Select('act')
            ->from('App:Activite', 'act')
            ->andWhere('a.posteTravail = :val')
            ->setParameter('val', $value)
            ->andWhere('act = a.activite')
            ->groupBy('act.id')
            ->orderBy('act.reference', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }


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
