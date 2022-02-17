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

    #[Route('/admin/products', name: 'admin_product_index')]
    public function adminIndex(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin/product/create', name: 'product_create')]
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
            return $this->redirectToRoute('admin_product_index');
        }
        return $this->render('admin/productForm.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}
