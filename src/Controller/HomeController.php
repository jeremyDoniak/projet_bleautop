<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits', name: 'produits')]
    public function produits(): Response
    {
        return $this->render('/home/produits.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/renovation', name: 'renovation')]
    public function renovation(): Response
    {
        return $this->render('/home/renovation.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('/home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/achat', name: 'achat')]
    public function achat(): Response
    {
        return $this->render('/home/achat.html.twig', [
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

    #[Route('/produit', name: 'produit')]
    public function produit(): Response
    {
        return $this->render('/home/produit.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_packs', name: 'produits_packs')]
    public function produitsPacks(): Response
    {
        return $this->render('/home/produits_packs.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_prises', name: 'produits_prises')]
    public function produitsPrises(): Response
    {
        return $this->render('/home/produits_prises.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_renovation', name: 'produits_renovation')]
    public function produitsRenovation(): Response
    {
        return $this->render('/home/produits_renovation.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_volumes', name: 'produits_volumes')]
    public function produitsVolumes(): Response
    {
        return $this->render('/home/produits_volumes.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
