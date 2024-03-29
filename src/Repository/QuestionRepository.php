<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
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
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public static function findRootQuestion(): ?Question
    {
        return self::createQueryBuilder('r')
            ->andWhere('r.id = :val')
            ->setParameter('vel', -1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    */

    public function findOneQuestionByReponseID($reponse_id)
    {

        $data =  $this->createQueryBuilder('r')
            ->andWhere('r.id_parent_reponse = :val')
            ->setParameter('val', $reponse_id)
            ->getQuery()
            ->getOneOrNullResult();

        if ($data)
            $data = array($data->jsonSerialize());

        return $data;

    }

    public function findRootQuestion()
    {
        $data =  $this->createQueryBuilder('r')
            ->andWhere('r.id_parent_reponse = :val')
            ->setParameter('val', -1)
            ->getQuery()
            ->getOneOrNullResult();

        return $data->jsonSerialize();
    }

    /**
     * @return Question[]
     */

    public function findAllOrphelins(): array
    {
        $repository = $repository = $this
            ->getEntityManager()
            ->getRepository(Reponse::class);
        $ids = $repository->getAllID();

        $questions = $this->findAll();
        $orphelins = array();

        foreach ($questions as $question) {
            if(!in_array($question->getIdParentReponse(), $ids) && ($question->getIdParentReponse() >= 0 || $question->getIdParentReponse() === null) )
                $orphelins[] = $question;
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
