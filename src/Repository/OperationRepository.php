<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    // /**
    //  * @return Operation[] Returns an array of Operation objects
    //  */

    public function findAllbyGE($ge)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.gammeEnveloppe = :val')
            ->setParameter('val', $ge)
            ->orderBy('o.numero', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findbyGEandNumero($ge, $numero)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.gammeEnveloppe = :val')
            ->andWhere('o.numero = :val2')
            ->setParameter('val', $ge)
            ->setParameter('val2', $numero)
            ->orderBy('o.numero', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Operation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
