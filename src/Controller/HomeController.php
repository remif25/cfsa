<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $hasAccess = $this->isGranted('ROLE_LECTEUR');
        if (!$hasAccess)
            return $this->redirectToRoute('app_login');

        $user = $this->getUser();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hasAccess' => $hasAccess,
            'user' => $user
        ]);
    }


    /**
     * @Route("/no-permission", name="no-permission")
     */
    public function noPermission()
    {
        $error = "Vous n'avez pas accès au back-office";
        $hasAccess = $this->isGranted('ROLE_LECTEUR');
        if (!$hasAccess)
            return $this->redirectToRoute('app_login');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hasAccess' => $hasAccess,
            'error' => $error
        ]);
    }
}
