<?php

namespace App\Controller;

use App\Service\CartService;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $categoryId = $categoryRepository->findOneBy(['name' => 'packs'])->getId();
        $products = $productRepository->findBy(['category' => $categoryId], ['id' => 'DESC'], 5);
        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/renovation', name: 'renovation')]
    public function renovation(ProductRepository $productRepository, CartService $cartService): Response
    {
        $total = $cartService->getTotal();
        $cart = $cartService->getCart();
        $products = $productRepository->findAll();
        return $this->render('/home/renovation.html.twig', [
            'products' => $products,
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    // #[Route('/contact', name: 'contact')]
    // public function contact(): Response
    // {
    //     return $this->render('/home/contact.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    #[Route('/cart', name: 'cart')]
    public function cart(): Response
    {
        return $this->render('/home/cart.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/cgu_cgv', name: 'cgu_cgv')]
    public function cguCgv(): Response
    {
        return $this->render('/home/cgu_cgv.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/faq', name: 'faq')]
    public function faq(): Response
    {
        return $this->render('/home/faq.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
