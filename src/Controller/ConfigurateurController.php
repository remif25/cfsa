<?php

namespace App\Controller;

use App\Entity\GammeEnveloppe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurateurController extends AbstractController
{
    /**
     * @Route("/configurateur/{slug}", name="configurateur")
     */
    public function configGE($slug)
    {
        $ge = $this->getDoctrine()
            ->getRepository(GammeEnveloppe::class)
            ->findOneBySlug($slug);

        $ge->createConfiguration();

       /* foreach ($ge->configurations as $configuration) {
            var_dump($configuration);
        }*/


        return $this->render('configurateur/configurateur.html.twig', [
            'controller_name' => 'ConfigurateurController',
            'ge' => $ge
        ]);
    }

    /**
     * @Route("/configurateur", name="configurateur_index")
     */

    public function index()
    {


        return $this->render('configurateur/index.html.twig', [
            'controller_name' => 'ConfigurateurController',
        ]);
    }
}
