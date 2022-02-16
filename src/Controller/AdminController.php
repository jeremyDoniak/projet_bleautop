<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin_produits', name: 'admin_produits')]
    public function produits(): Response
    {
        return $this->render('admin/produits.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin_utilisateurs', name: 'admin_utilisateurs')]
    public function utilisateurs(): Response
    {
        return $this->render('admin/utilisateurs.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
