<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends EasyAdminController
{

    /**
     * @Route("/naviquiz", name="config_naviquiz")
     */
    public function index()
    {
        return $this->render('admin/naviquiz.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
