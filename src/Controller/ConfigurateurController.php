<?php

namespace App\Controller;

use App\Entity\GammeEnveloppe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurateurController extends AbstractController
{
    /**
     * @Route("/configurateur/config/{slug}", name="configurateur")
     */
    public function configGE($slug)
    {
        $ge = $this->getDoctrine()
            ->getRepository(GammeEnveloppe::class)
            ->findOneBySlug($slug);

        $ge->createConfiguration();

        return $this->render('configurateur/configurateur.html.twig', [
            'controller_name' => 'ConfigurateurController',
            'ge' => $ge,
            'configurations' => json_encode($ge, JSON_UNESCAPED_UNICODE)
        ]);
    }

    /**
     * @Route("/configurateur/export", name="configurateur_export")
     */

    public function exportConfig(Request $request)
    {
        $is_prod = $request->request->get('type') === 'Exportez - PROD' ? true : false;

        $ge = $this->getDoctrine()
            ->getRepository(GammeEnveloppe::class)
            ->findOneById($request->request->get('gammeEnveloppe'));

        /*        $ge->createConfiguration();*/

        $regles = $request->request->get('regle');

        return $this->exportCSV($ge, $regles, $is_prod);
    }

    /**
     * @Route("/configurateur", name="configurateur_index")
     */

    public function index()
    {
        $ges = $this->getDoctrine()->getRepository(GammeEnveloppe::class)->findAll();
        return $this->render('configurateur/index.html.twig', [
            'controller_name' => 'ConfigurateurController',
            'ges' => $ges
        ]);
    }

    public function exportCSV(GammeEnveloppe $ge, Array $regles, bool $is_prod)
    {

        $endl = "\r\n";
        $csv = "Séq;Code PDT;Désignation PDT;Code Activité;Désignation". $endl;

        foreach ($ge->getOperations() as $operation) {
            $linkRegleOperation = $operation->getLinkRegleOperation();
            if($linkRegleOperation) {
                if(in_array($regles[$linkRegleOperation->getRegle()->getId()], $linkRegleOperation->getBranche()))
                    $csv .= $operation->getNumero() . ";" . $operation->getPdt()->getReference() . ";" . $operation->getPdt()->getDescription() . ";" . $operation->getActivite()->getReference() . ";" . $operation->getActivite()->getDescription() . $endl;

            } else {
                $csv .= $operation->getNumero() . ";" . $operation->getPdt()->getReference() . ";" . $operation->getPdt()->getDescription() . ";" . $operation->getActivite()->getReference() . ";" . $operation->getActivite()->getDescription() . $endl;
            }
        }

        $response = new Response(mb_convert_encoding($csv, 'WINDOWS-1252'));

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'exportGEPROD.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
