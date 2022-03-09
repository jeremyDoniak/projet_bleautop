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

    // #[Route('/admin_products', name: 'admin_products')]
    // public function produits(ProductRepository $productRepository): Response
    // {
    //     $products = $productRepository->findAll();
    //     return $this->render('admin/products.html.twig', [
    //         'products' => $products,
    //     ]);
    // }

    // #[Route('/admin_users', name: 'admin_users')]
    // public function utilisateurs(UserRepository $userRepository): Response
    // {
    //     $users = $userRepository->findAll();
    //     return $this->render('admin/users.html.twig', [
    //         'users' => $users,
    //     ]);
    // }
}
