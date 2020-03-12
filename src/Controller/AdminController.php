<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\ActiviteProto;
use App\Entity\CentreProduction;
use App\Entity\Departement;
use App\Entity\GammeEnveloppe;
use App\Entity\LinkRegleOperation;
use App\Entity\Operation;
use App\Entity\PosteTravail;
use App\Entity\PosteTravailProto;
use App\Entity\Question;
use App\Entity\Regle;
use App\Entity\Reponse;
use App\Entity\User;
use App\Form\GammeEnveloppeType;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getEM(): EntityManager {
        return $this->getDoctrine()->getManager();
    }

    public function getUrlPackage() : UrlPackage
    {
        return new UrlPackage(
            'https://cfsa.repliqa.fr/',
            new EmptyVersionStrategy());
    }

    /**
     * @Route("/export/ge", name="export_ge")
     */
    public function exportGE()
    {
        $urlPackage = $this->getUrlPackage();
        return $this->render('admin/export/ge.html.twig', [
            'controller_name' => 'AdminController',
            'url_model_file' => $urlPackage->getUrl('model/model_import_donnees.csv')
        ]);
    }

    /**
     * @Route("/export/structure", name="export_structure")
     */
    public function exportStructure()
    {
        $urlPackage = $this->getUrlPackage();
        return $this->render('admin/export/structure.html.twig', [
            'controller_name' => 'AdminController',
            'url_model_file' => $urlPackage->getUrl('model/model_import_donnees.csv')
        ]);
    }

    /**
     * @Route("/import/data", name="import_data")
     */
    public function importDATA()
    {
        $urlPackage = $this->getUrlPackage();
        return $this->render('admin/import/data.html.twig', [
            'controller_name' => 'AdminController',
            'url_model_file' => $urlPackage->getUrl('model/model_import_donnees.csv')
        ]);
    }


    /**
     * @Route("/import/data/pdt_proto", name="import_data_pdt_proto")
     */
    public function importPDTPROTO()
    {
        $urlPackage = $this->getUrlPackage();

        return $this->render('admin/import/pdtproto.html.twig', [
            'controller_name' => 'AdminController',
            'url_model_file' => $urlPackage->getUrl('model/model_import_pdt_proto.csv')
        ]);
    }

    /**
     * @Route("/import/data/save", name="import_data_save")
     */
    public function importDataSave(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $fileimport = $request->files->get('importfile');
        $jumpFirstLine = !$request->get('firstline');
        $pdtExistants = $this->getDoctrine()
            ->getRepository(PosteTravail::class)
            ->findAll();

        if($fileimport) {
            $filename = $fileimport->getPathName();
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {
                if (!$jumpFirstLine) {
                    $cDep = trim($getData[0]);
                    $dDep = trim($getData[1]);
                    $cCP = trim($getData[2]);
                    $dCP = trim($getData[3]);
                    $cPDT = trim($getData[4]);
                    $dPDT = trim($getData[5]);
                    $cAct = trim($getData[6]);
                    $dAct = trim($getData[7]);

                    if ($cAct !== "") {

                        $activite = $this->getDoctrine()
                            ->getRepository(Activite::class)
                            ->findOneByReference($cAct);

                        if (!$activite) {
                            $activite = new Activite();
                            $activite->setReference($cAct);
                        }

                        $activite->setDescription($dAct);
                    }

                    $posteTravail = $this->getDoctrine()
                        ->getRepository(PosteTravail::class)
                        ->findOneByReference($cPDT);

                    if ($cPDT !== "") {
                        if (!$posteTravail) {
                            $posteTravail = new PosteTravail();
                            $posteTravail->setReference($cPDT);

                        }

                        $posteTravail->setDescription($dPDT);
                        if ($activite !== null)
                            $posteTravail->addActivite($activite);
                    }

                    $centreProduction = $this->getDoctrine()
                        ->getRepository(CentreProduction::class)
                        ->findOneByReference($cCP);

                    if ($cCP !== "") {
                        if (!$centreProduction && $cCP !== "") {
                            $centreProduction = new CentreProduction();
                            $centreProduction->setReference($cCP);

                        }

                        $centreProduction->setDesignation($dCP);
                        if ($posteTravail !== null)
                            $centreProduction->addPdt($posteTravail);
                    }

                    if ($cDep !== "") {
                        $departement = $this->getDoctrine()
                            ->getRepository(Departement::class)
                            ->findOneByReference($cDep);

                        if (!$departement) {
                            $departement = new Departement();
                            $departement->setReference($cDep);
                        }

                        $departement->setDesignation($dDep);
                        if ($centreProduction !== null)
                            $departement->addCentreproduction($centreProduction);
                    }

                    if ($activite !== null)
                        $em->persist($activite);

                    if ($posteTravail !== null) {
                        $em->persist($posteTravail);
                        $pdts[] = $posteTravail;
                    }


                    if ($centreProduction !== null)
                        $em->persist($centreProduction);

                    if ($departement !== null)
                        $em->persist($departement);

                    $em->flush();
                } else {
                    $jumpFirstLine = false;
                }
            }

            foreach ($pdtExistants as $pdtExistant) {
                $check = true;
                foreach ($pdts as $pdt) {
                    if ($pdtExistant->getReference() === $pdt->getReference())
                        $check = false;
                }

                if ($check)  {
                    $em->remove($pdtExistant);
                    $em->flush();
                }
            }


            $urlPackage = $this->getUrlPackage();
            return $this->render('admin/import/data.html.twig', [
                'controller_name' => 'AdminController',
                'url_model_file' => $urlPackage->getUrl('model/model_import_donnees.csv')
            ]);
        }
    }


    /**
     * @Route("/import/data/pdt_proto/save", name="import_data_pdt_proto_save")
     */
    public function importPDTPROTOSave(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $fileimport = $request->files->get('importfile');
        $jumpFirstLine = !$request->get('firstline');
        $pdtExistants = $this->getDoctrine()
            ->getRepository(PosteTravailProto::class)
            ->findAll();

        if($fileimport) {
            $filename = $fileimport->getPathName();
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {
                if (!$jumpFirstLine) {
                    $cDep = trim($getData[0]);
                    $dDep = trim($getData[1]);
                    $cCP = trim($getData[2]);
                    $dCP = trim($getData[3]);
                    $cPDTPROTO = trim($getData[4]);
                    $dPDTPROTO = trim($getData[5]);
                    $cActPROTO = trim($getData[6]);
                    $dActPROTO = trim($getData[7]);
                    $cPDT = trim($getData[8]);
                    $cAct = trim($getData[9]);

                    if ($cActPROTO !== "") {

                        $activiteProto = $this->getDoctrine()
                            ->getRepository(ActiviteProto::class)
                            ->findOneByReference($cActPROTO);

                        if (!$activiteProto) {
                            $activiteProto = new ActiviteProto();
                            $activiteProto->setReference($cActPROTO);
                        }

                        $activiteProto->setDescription($dActPROTO);

                        if ($cAct !== "") {
                            $activite = $this->getDoctrine()
                                ->getRepository(Activite::class)
                                ->findOneByReference($cAct);

                            if($activite)
                                $activiteProto->setActivite($activite);

                        }
                    }

                    if($cPDTPROTO !== "") {
                        $posteTravailProto = $this->getDoctrine()
                            ->getRepository(PosteTravailProto::class)
                            ->findOneByReference($cPDTPROTO);

                        if ($cPDTPROTO !== "") {
                            if (!$posteTravailProto) {
                                $posteTravailProto = new PosteTravailProto();
                                $posteTravailProto->setReference($cPDTPROTO);

                            }

                            $posteTravailProto->setDescription($dPDTPROTO);
                            if ($activiteProto !== null)
                                $posteTravailProto->addActivitesproto($activiteProto);

                            if($cPDT !== "") {
                                $pdt = $this->getDoctrine()
                                    ->getRepository(PosteTravail::class)
                                    ->findOneByReference($cPDT);

                                if($pdt)
                                    $posteTravailProto->setPdt($pdt);

                            }
                        }
                    }

                    $centreProduction = $this->getDoctrine()
                        ->getRepository(CentreProduction::class)
                        ->findOneByReference($cCP);

                    if ($cCP !== "") {
                        if (!$centreProduction && $cCP !== "") {
                            $centreProduction = new CentreProduction();
                            $centreProduction->setReference($cCP);

                        }

                        $centreProduction->setDesignation($dCP);
                        if ($posteTravailProto !== null)
                            $centreProduction->addPdtsproto($posteTravailProto);
                    }

                    if ($cDep !== "") {
                        $departement = $this->getDoctrine()
                            ->getRepository(Departement::class)
                            ->findOneByReference($cDep);

                        if (!$departement) {
                            $departement = new Departement();
                            $departement->setReference($cDep);
                        }

                        $departement->setDesignation($dDep);
                        if ($centreProduction !== null)
                            $departement->addCentreproduction($centreProduction);
                    }

                    if ($activiteProto !== null)
                        $em->persist($activiteProto);

                    if ($posteTravailProto !== null) {
                        $em->persist($posteTravailProto);
                        $pdtsProto[] = $posteTravailProto;
                    }


                    if ($centreProduction !== null)
                        $em->persist($centreProduction);

                    if ($departement !== null)
                        $em->persist($departement);

                    $em->flush();
                } else {
                    $jumpFirstLine = false;
                }
            }

            foreach ($pdtExistants as $pdtExistant) {
                $check = true;
                foreach ($pdtsProto as $pdtProto) {
                    if ($pdtExistant->getReference() === $pdtProto->getReference())
                        $check = false;
                }

                if ($check)  {
                    $em->remove($pdtExistant);
                    $em->flush();
                }
            }

            $urlPackage = $this->getUrlPackage();
            return $this->render('admin/import/data.html.twig', [
                'controller_name' => 'AdminController',
                'url_model_file' => $urlPackage->getUrl('model/model_import_donnees.csv')
            ]);
        }
    }

    /**
     * @Route("/import/link", name="import_link")
     */
    public function importLinkPDTActivite()
    {
        $urlPackage = $this->getUrlPackage();
        return $this->render('admin/import/link.html.twig', [
            'controller_name' => 'AdminController',
            'url_model_file' => $urlPackage->getUrl('model/model_import_donnees.csv')
        ]);
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
        $deleteLink = false;
        $ge = $em->find(GammeEnveloppe::class, $request->request->get('gamme_enveloppe')['id']);

        foreach ($request->request->get('gamme_enveloppe')['operations'] as $operationdata) {
            $numero = $operationdata['numero'];
            if($numero !== '') {
                $operation = $this->getDoctrine()->getRepository(Operation::class)->findbyGEandNumero($ge->getId(), $numero);
                $regle = $em->find(Regle::class, isset($operationdata['linkregleoperation']['regle']) ? $operationdata['linkregleoperation']['regle'] : 0);

                if(!isset($operationdata['linkregleoperation']['regle']))
                    $deleteLink = true;

                $pdt = $em->find(PosteTravail::class, $operationdata['pdt']);
                $activite = $em->find(Activite::class, $operationdata['activite']);
                if (!$operation) {
                    $operation = new Operation();
                    $linkRegletoOperation = new LinkRegleOperation();
                } else {
                    $linkRegletoOperation = $this->getDoctrine()->getRepository(LinkRegleOperation::class)->findOneByOperation($operation->getId());

                    if (!$linkRegletoOperation)
                        $linkRegletoOperation = new LinkRegleOperation();
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

                if($deleteLink && $operation->getLinkRegleOperation()) {
                    $link = $operation->getLinkRegleOperation();
                    $em->remove($link);
                }
            }
        }
        $em->persist($ge);
        $em->flush();


        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => 'GammeEnveloppe',
        ));
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
            $check = $this->removeParentRecursive($datas, $em);
        }

        if ($check) {
            return new JsonResponse(
                [
                    'statut' => 'ok',
                    'message' => "Sauvegarde de l'arbre",
                ],
                Response::HTTP_OK
            );
        }
        return new JsonResponse(
            [
                'statut' => 'error',
                'message' => "Les données n'ont pas été mis à la courbeille",
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/ge/{type_object}/{constraint}", name="get_objects")
     */
    public function getDatas($type_object, $constraint) {

        $objects= array();
        $objectsArray = array();

        if ($constraint !== 'null') {
            if ($type_object === 'activites')
                $objects = $this->getDoctrine()->getRepository(Activite::class)->find($constraint)->getPdts();
            elseif ($type_object === 'pdts')
                $objects = $this->getDoctrine()->getRepository(PosteTravail::class)->find($constraint)->getActivites();
            elseif ($type_object === 'regles')
                $objects = $this->getDoctrine()->getRepository(Regle::class)->findByGE($constraint);
        } else {
            if ($type_object === 'activites')
                $objects = $this->getDoctrine()->getRepository(PosteTravail::class)->findAll();
            elseif ($type_object === 'pdts')
                $objects = $this->getDoctrine()->getRepository(Activite::class)->findAll();
            elseif ($type_object === 'regles')
                $objects = $this->getDoctrine()->getRepository(Regle::class)->findAll();
        }


        foreach ($objects as $object) {
            $objectsArray[] = $object;
        }

        $objects = $objectsArray;

        if (isset($objects) && $objects) {
            return new JsonResponse(
                [
                    'success' => true,
                    'results' => $objects,
                ],
                Response::HTTP_OK
            );
        } else {
            return new JsonResponse(
                [
                    'fail' => true,
                ],
                Response::HTTP_OK
            );
        }
    }

    public function persistUserEntity($user)
    {
        $currentUser = $this->getUser();

        if (!$user->getPlainPassword()) {
            if ($user->getId() !== null && $user->getId() == $currentUser->getId()) {
                $user->setPlainPassword($currentUser->getPlainPassword());
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            } elseif (!$user->getPassword()) {
                $user->setPlainPassword('Patek1839');
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            }
        } else {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        $currentUser = $this->getUser();

        if (!$user->getPlainPassword()) {
            if ($user->getId() !== null && $user->getId() == $currentUser->getId()) {
                $user->setPlainPassword($currentUser->getPlainPassword());
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            } elseif (!$user->getPassword()) {
                $user->setPlainPassword('Patek1839');
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            }
        } else {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
        parent::updateEntity($user);
    }


    public function removeParentRecursive($datas, $em) {
        foreach ($datas as $data) {
            if(array_key_exists('children', $data)) {
                $this->removeParentRecursive($data['children'], $em);
            }
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
        return true;
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
