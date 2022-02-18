<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produits', name: 'produits')]
    public function produits(): Response
    {
        return $this->render('/product/produits.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produit', name: 'produit')]
    public function produit(): Response
    {
        return $this->render('/product/produit.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_packs', name: 'produits_packs')]
    public function produitsPacks(): Response
    {
        return $this->render('/product/produits_packs.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_prises', name: 'produits_prises')]
    public function produitsPrises(): Response
    {
        return $this->render('/product/produits_prises.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_renovation', name: 'produits_renovation')]
    public function produitsRenovation(): Response
    {
        return $this->render('/product/produits_renovation.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/produits_volumes', name: 'produits_volumes')]
    public function produitsVolumes(): Response
    {
        return $this->render('/product/produits_volumes.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
    #[Route('/admin/products', name: 'admin_products_index')]
    public function adminIndex(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin/products/create', name: 'products_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg = $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();
            $nomImg = time() . $extensionImg;
            $infoImg->move($this->getParameter('dossier_img'), $nomImg);
            $product->setImg($nomImg);

            $manager = $managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été ajouté');
            return $this->redirectToRoute('admin_products_index');
        }
        return $this->render('admin/productForm.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

}
