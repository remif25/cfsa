<?php

namespace App\Controller;

use App\Entity\GammeEnveloppe;
use App\Entity\Operation;
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
        $gamme = $request->request->get('gamme');
        $article = $request->request->get('article');

        $ge = $this->getDoctrine()
            ->getRepository(GammeEnveloppe::class)
            ->findOneById($request->request->get('gammeEnveloppe'));

        /*        $ge->createConfiguration();*/

        $regles = $request->request->get('regle');

        return $this->exportCSV($ge, $regles, $is_prod, $gamme, $article);
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

    public function exportCSV(GammeEnveloppe $ge, Array $regles, bool $is_prod, string $gamme, string $article)
    {
        foreach ($ge->getOperations() as $operation) {
            $linkRegleOperation = $operation->getLinkRegleOperation();
            if(($linkRegleOperation && in_array($regles[$linkRegleOperation->getRegle()->getId()], $linkRegleOperation->getBranche())) || !$linkRegleOperation)
                    $datas[] = $this->setDatas($operation, $gamme, $article, $is_prod);

        }

        $filename = $is_prod ? 'export_' . $ge->getReference() .'_gamme_'. $gamme. '_PROD.csv' : 'export_' . $ge->getReference() .'_gamme_'. $gamme. '_PROTO.csv';

        $csv = $this->convertArrayToCSV($datas);
        $response = new Response(mb_convert_encoding($csv, 'WINDOWS-1252'));
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    public function setDatas(Operation $operation, string $gamme, string $article, bool $is_prod) :array
    {
        /**
         *  0/ Gamme : référence de la gamme (A répeter jusqu'à la fin)
         *  1/ Article : référence de l'article (A répeter jusqu'à la fin)
         *  2/ Séquence : numero de l'opération
         *  3/ Poste_travail : référence du Poste de travail
         *  4/ Activite : référencde de l'activité
         *  5/ activite_suppl : référence du supplément d'activité (ne dois plus être utulisé dans les nouvelles gammes
         *  6/ TEMPS_MEO : Temps de réglage en heure
         *  7/ TEMPS_MO : Temps d'ouvrage en heure (Temps de l'opérateur/regleur)
         *  8/ TEMPS_MA :  Temps machine en heure
         *  9/ Nombre_piece : Quantité de pièce de référence
         *  10/ UINITE : unité de référence pour la quantité (Principalement 'PC' pour pièces)
         *  11/ Acheminement : Temps d'acheminement
         *  12/ UNITE : Unité de référence pour le temps d'acheminement - 1 = jour, 2 = heure, 3 = minute
         *  13/ surplus : Quantité de rebut attendu à l'opération en pourcentage
         *  14/ Saisie quantité : ?
         *  15/ Suivi des temps : ?
         *  16/ TargetH : ? (toujours mettre 'a')
         *  17/ TargetO : ? (toujours mettre 'b')
         */
        $datas[0] = $gamme;
        $datas[1] = $article;
        $datas[2] = $operation->getNumero();
        $datas[3] = !$is_prod && $operation->getPdt()->getPosteTravailProto() !== null ?  $operation->getPdt()->getPosteTravailProto()->getReference(): $operation->getPdt()->getReference();
        $datas[4] = !$is_prod && $operation->getActivite()->getActiviteProto() !== null ? $operation->getActivite()->getActiviteProto()->getReference() : $operation->getActivite()->getReference();
        $datas[5] = ''; // Supplément Act
        $datas[6] = ''; // Temps réglage
        $datas[7] = ''; // Temps MO
        $datas[8] = ''; // Temps MA
        $datas[9] = 100;
        $datas[10] = 'PC';
        $datas[11] = 8;
        $datas[12] = 2;
        $datas[13] = ''; // surplus
        $datas[14] = ''; // Saisie quantité
        $datas[15] = ''; // Suivie des temps
        $datas[16] = 'a';
        $datas[17] = 'b';


        return $datas;
    }

    public function convertArrayToCSV(array $datas) : string
    {
        $endl = "\r\n";
        $csv = "Gamme;Article;Séquence;Poste_travail;Activite;activite_suppl;TEMPS_MEO;TEMPS_MO;TEMPS_MA;Nombre_piece;UNITE;ACHEMINEMENT;UNITE;surplus;Saisie quantité; Suivi des temps; TargetH;TargetO". $endl;
        foreach ($datas as $line) {
            foreach ($line as $data) {
                $csv .= $data . ';';
            }
            $csv = substr($csv, 0,-1) . $endl;
        }
        return $csv;
    }
}
