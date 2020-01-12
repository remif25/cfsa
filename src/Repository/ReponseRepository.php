<?php

namespace App\Repository;

use App\Entity\Question;
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

    /**
     * @return Reponse[]
     */
    public function findAllOrphelins(): array
    {
        $repository = $repository = $this
            ->getEntityManager()
            ->getRepository(Question::class);
        $ids = $repository->getAllID();

        $reponses = $this->findAll();
        $orphelins = array();

        foreach ($reponses as $reponse) {
            if(!in_array($reponse->getIdParentQuestion(), $ids))
                $orphelins[] = $reponse;
        }

        return $orphelins;
    }

    public function getAllID()
    {
        $datas = $this->createQueryBuilder('r')
            ->andWhere('r.id >= 0')
            ->getQuery()
            ->getResult();


        foreach ($datas as &$data) {
            $ids[] = $data->getID();
        }

        return $ids;

    }
}
