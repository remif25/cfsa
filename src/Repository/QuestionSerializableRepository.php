<?php

namespace App\Repository;

use App\Entity\QuestionSerializable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QuestionSerializable|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionSerializable|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionSerializable[]    findAll()
 * @method QuestionSerializable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionSerializableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionSerializable::class);
    }

    // /**
    //  * @return QuestionSerializable[] Returns an array of QuestionSerializable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionSerializable
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
