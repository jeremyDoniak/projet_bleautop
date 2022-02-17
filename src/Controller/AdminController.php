<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function produits(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin/produits.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin_utilisateurs', name: 'admin_utilisateurs')]
    public function utilisateurs(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/utilisateurs.html.twig', [
            'users' => $users,
        ]);
    }
}
