<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\PosteTravail;
use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NaviquizController extends AbstractController
{
    /**
     * @Route("/naviquiz", name="naviquiz")
     */
    public function index(Request $request)
    {
        if ($request->query->get('pw') === "eb70aa6ff6792225e8e4f7467d9982ac") {

            return $this->render('naviquiz/index.html.twig', [
                'controller_name' => 'Naviquiz',
                'tree' => json_encode($this->getTree(), JSON_UNESCAPED_UNICODE),
            ]);
        } else {
            return $this->render('naviquiz/index.html.twig', [
                'permission_refused' => 1,
            ]);
        }
    }

    /**
     * @Route("/api/tree/naviquiz", name="tree_naviquiz")
     */
    public function getJSONTree()
    {
        $tree = $this->getTree();

        return $this->json($tree);
    }

    /**
     * @Route("/api/tree/question/ophelins", name="question_orphelins_naviquiz")
     */
    public function getJSONReponseOphelins()
    {
        $repository = $this->getDoctrine()->getRepository(Question::class);
        return $this->json($repository->findAllOrphelins());
    }

    /**
     * @Route("/api/tree/reponse/ophelins", name="reponse_orphelins_naviquiz")
     */
    public function getJSONQuestionOphelins()
    {
        $repository = $this->getDoctrine()->getRepository(Reponse::class);
        return $this->json($repository->findAllOrphelins());
    }

    public function getTree() {
        $repository = $this->getDoctrine()->getRepository(Question::class);
        $rootQuestion = $repository->findRootQuestion();
        $rootQuestion = array($rootQuestion);
        $tree = self::recursive($rootQuestion);

        return $tree;
    }


    public function getChildren($parent) {
        if (isset($parent['id_parent_question'])) {
            $repository = $this->getDoctrine()->getRepository(Question::class);
            return $repository->findOneQuestionByReponseID($parent['id']);
        }
        if (isset($parent['id_parent_reponse'])) {
            $repository = $this->getDoctrine()->getRepository(Reponse::class);
            return $repository->findReponsesByQuestionID($parent['id']);
        }

        return 0;
    }

    public function getChildrenForFancytree($parent) {
        if (isset($parent['id_parent_question'])) {
            $repository = $this->getDoctrine()->getRepository(Question::class);
            return $repository->findOneQuestionByReponseID($parent['id']);
        }
        if (isset($parent['id_parent_reponse'])) {
            $repository = $this->getDoctrine()->getRepository(Reponse::class);
            return $repository->findReponsesByQuestionID($parent['id']);
        }

        return 0;
    }

    public function recursive(&$arraydatas) {
        if (is_array($arraydatas)) {
            foreach ($arraydatas as &$arraydata) {
                $children = self::getChildren($arraydata);

                if(count($children)  > 0) {
                    $arraydata['children'] = $this->recursive($children);
                }
            }
        }
        return $arraydatas;
    }

    public function recursiveForFancytree(&$arraydatas) {
        if (is_array($arraydatas)) {
            foreach ($arraydatas as &$arraydata) {
                $children = self::getChildrenForFancytree($arraydata);

                if(count($children)  > 0) {
                    $arraydata['children'] = $this->recursive($children);
                }
            }
        }
        return $arraydatas;
    }

    public function utf8ize($d) {
        if (is_array($d))
            foreach ($d as $k => $v)
                $d[$k] = self::utf8ize($v);

        else if(is_object($d))
            foreach ($d as $k => $v)
                $d->$k = self::utf8ize($v);

        else
            return utf8_encode($d);

        return $d;
    }
}
