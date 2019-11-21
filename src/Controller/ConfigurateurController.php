<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConfigurateurController extends AbstractController
{
    /**
     * @Route("/configurateur", name="configurateur")
     */
    public function index()
    {
        return $this->render('configurateur/index.html.twig', [
            'controller_name' => 'ConfigurateurController',
        ]);
    }
}
