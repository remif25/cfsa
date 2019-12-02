<?php

namespace App\Controller;

use App\Entity\GammeEnveloppe;
use App\Entity\Operation;
use App\Entity\PosteTravail;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\GammeEnveloppeType;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends EasyAdminController
{

    public function getEM(): EntityManager
    {

        return $this->getDoctrine()->getManager();

    }

    /**
     * @Route("/naviquiz", name="config_naviquiz")
     */
    public function configNaviquiz()
    {
        return $this->render('admin/naviquiz.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/ge", name="config_ge")
     */
    public function configGEAction()
    {
        $em = $this->getEM();

        if(isset($_GET['id']) && $em->find(GammeEnveloppe::class, $_GET['id'])) {

            $ge = $em->find(GammeEnveloppe::class, $_GET['id']);

            $operations = array();

            for ($i = 0; $i < 50; $i++) {
                $operations[$i] = new Operation(random_int(99999999, 9999999999999));
            }


            $i = 0;
            foreach($ge->getOperations() as $operation) {
                unset($operations[$i]);
                $operations[$i] = $operation;
                $ge->removeOperation($operation);
                $i++;
            }

            foreach ($operations as $operation) {
                $operation->setId = random_int(99999999, 9999999999999);
                $ge->addOperation($operation);
            }

            $form = $this->createForm(GammeEnveloppeType::class, $ge);

            return $this->render('admin/ge/config.html.twig', [
                'controller_name' => 'AdminController',
                'ge' => $ge,
                'form' => $form->createView()
            ]);
        }

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/api/tree/naviquiz/save", name="save_naviquiz")
     */
    public function saveTree(Request $request)
    {
        $data = json_decode($request->getContent(), true);


        if($data['children']) {
            $data = $data['children'];
            $saveAll = self::recursive($data, $data);
        }

        return new JsonResponse(
            [
                'message' => json_encode($saveAll),
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/tree/naviquiz/removeparent", name="remove_element_naviquiz")
     */
    public function removeElementTree(Request $request)
    {
        $datas = json_decode($request->getContent(), true);

        if(isset($datas['children'][0]['children'])) {
            $datas = $datas['children'][0]['children'];
            $em = $this->getEM();
            foreach ($datas as $data) {
                if (array_key_exists('id_parent_question', $data['data'])) {
                    $reponse = $em->find(Reponse::class, $data['data']['id']);
                    $reponse->setIdParentQuestion(0);
                    $em->persist($reponse);
                }
                if(array_key_exists('id_parent_reponse', $data['data']) && $data['data']['id_parent_reponse'] != -1) {
                    $question = $em->find(Question::class, $data['data']['id']);
                    $question->setIdParentReponse(0);
                    $em->persist($question);
                }
                $em->flush();
            }
        }

        return new JsonResponse(
            [
                'message' => 'Sauvegarde ok',
            ],
            Response::HTTP_OK
        );
    }

    public function recursive($arraydatas, $parent) {
        $em = $this->getEM();

        if (is_array($arraydatas)) {
            foreach ($arraydatas as $arraydata) {
                if (isset($arraydata['children'])) {
                    $this->recursive($arraydata['children'], $arraydata);


                }
                if (array_key_exists('id_parent_question', $arraydata['data'])) {
                    $reponse = $em->find(Reponse::class, $arraydata['data']['id']);
                    $reponse->setIdParentQuestion($parent['data']['id']);
                    $em->persist($reponse);

                }
                if(array_key_exists('id_parent_reponse', $arraydata['data']) && $arraydata['data']['id_parent_reponse'] != -1) {
                    $question = $em->find(Question::class, $arraydata['data']['id']);
                    $question->setIdParentReponse($parent['data']['id']);
                    $em->persist($question);

                }
                $em->flush();
            }

        }
        return new JsonResponse(
            [
                'message' => 'Sauvegarde ok',
            ],
            Response::HTTP_OK
        );
    }
}
