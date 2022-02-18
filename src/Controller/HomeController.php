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


}
