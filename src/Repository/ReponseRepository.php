<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Reponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reponse[]    findAll()
 * @method Reponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    // /**
    //  * @return Reponse[] Returns an array of Reponse objects
    //  */


    public function findReponsesByQuestionID($question_id): ?Array
    {
        $datas =  $this->createQueryBuilder('r')
            ->andWhere('r.id_parent_question = :val')
            ->setParameter('val', $question_id)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;

        foreach ($datas as &$data) {
            $data = $data->jsonSerialize();
        }

        return $datas;
    }

}
