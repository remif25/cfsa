<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\GammeEnveloppe;
use App\Entity\LinkRegleOperation;
use App\Entity\Operation;
use App\Entity\PosteTravail;
use App\Entity\Question;
use App\Entity\Regle;
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

    public function getEM(): EntityManager {
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
        if(isset($_GET['id']))
           return $this->displayGE($_GET['id']);

        return $this->redirectToRoute('admin');
    }

    public function displayGE($id) {
        $em = $this->getEM();
        $ge = $em->find(GammeEnveloppe::class, $id);
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

        ksort($operations);

        foreach ($operations as $operation) {
            $operation->setId = random_int(99999999, 9999999999999);
            $ge->addOperation($operation);
        }

        $form = $this->createForm(GammeEnveloppeType::class, $ge, [
            'action' => '/admin/api/ge/save',
            'method' => 'POST',
        ]);

        return $this->render('admin/ge/config.html.twig', [
            'controller_name' => 'AdminController',
            'ge' => $ge,
            'form' => $form->createView()
        ]);


        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/api/ge/save", name="save_ge")
     */
    public function saveGE(Request $request)
    {
        $em = $this->getEM();

        $ge = $em->find(GammeEnveloppe::class, $request->request->get('gamme_enveloppe')['id']);

        foreach ($request->request->get('gamme_enveloppe')['operations'] as $operationdata) {
            $numero = $operationdata['numero'];
            if($numero !== '') {
                $operation = $this->getDoctrine()->getRepository(Operation::class)->findbyGEandNumero($ge->getId(), $numero);
                $regle = $em->find(Regle::class, $operationdata['linkregleoperation']['regle']);
                $pdt = $em->find(PosteTravail::class, $operationdata['pdt']);
                $activite = $em->find(Activite::class, $operationdata['activite']);

                if (!$operation) {
                    $operation = new Operation();
                    $linkRegletoOperation = new LinkRegleOperation();
                } else {
                    $linkRegletoOperation = $this->getDoctrine()->getRepository(LinkRegleOperation::class)->findOneByOperation($operation->getId());
                }

                $banches = explode('-', $operationdata['linkregleoperation']['branche']);

                if($regle) {
                    $linkRegletoOperation->setRegle($regle)
                        ->setOperation($operation)
                        ->setBranche($banches);
                    $em->persist($linkRegletoOperation);
                }

                $operation->setNumero($numero)
                    ->setActivite($activite)
                    ->setPdt($pdt);
                $em->persist($operation);

                $ge->addOperation($operation);
            }
        }
        $em->persist($ge);
        $em->flush();


        return $this->displayGE($ge->getId());
    }

    /**
     * @Route("/api/ge/deleteop", name="deleteop_ge")
     */

    public function deteleOP(Request $request) {
        $datas = json_decode($request->getContent(), true);
        $em = $this->getEM();
        $op = $em->find(Operation::class, $datas['operation_id']);
        $em->remove($op);
        $em->flush();

        return new JsonResponse(
            [
                'statut' => 'ok',
                'message' => "Suppresion de l'opération",
                'op_id' => $datas['operation_id']
            ],
            Response::HTTP_OK
        );
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
                'statut' => 'ok',
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
                'statut' => 'ok',
                'message' => "Sauvegarde de l'arbre",
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
                'status' => 'ok',
                'message' => 'Sauvegarde ok',
            ],
            Response::HTTP_OK
        );
    }
}
