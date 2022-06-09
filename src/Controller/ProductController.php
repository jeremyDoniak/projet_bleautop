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
    #[Route('/produits', name: 'produits')]
    public function produits(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('/product/produits.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produit/{id}', name: 'produit')]
    public function produit(ProductRepository $productRepository, int $id): Response
    {
        return $this->render('/product/produit.html.twig', [
            'product' => $productRepository->find($id),
        ]);
    }

    #[Route('/produits_packs', name: 'produits_packs')]
    public function produitsPacks(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('/product/produits_packs.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produits_prises', name: 'produits_prises')]
    public function produitsPrises(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('/product/produits_prises.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produits_renovation', name: 'produits_renovation')]
    public function produitsRenovation(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('/home/renovation.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produits_volumes', name: 'produits_volumes')]
    public function produitsVolumes(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('/product/produits_volumes.html.twig', [
            'products' => $products,
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

    #[Route('/admin/products/update/{id}', name: 'products_update')]
    public function update(ProductRepository $productRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $product = $productRepository->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg = $form['img']->getData();
            $nomOldImg = $product->getImg();
            if ($infoImg !== null) {
                $cheminOldImg = $this->getParameter('dossier_img') . '/' . $nomOldImg;
                if (file_exists($cheminOldImg)) {
                    unlink($cheminOldImg);
                }
                $extensionImg = $infoImg->guessExtension();
                $nomImg = time() . $extensionImg;
                $infoImg->move($this->getParameter('dossier_img'), $nomImg);
                $product->setImg($nomImg);
            } else {
                $product->setImg($nomOldImg);
            }
            
            $manager = $managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('admin_products_index');
        }
            
        return $this->render('admin/productForm.html.twig', [
            'productForm' => $form->createView(),
            'product' => $product
        ]);
    }

    #[Route('/admin/products/delete/{id}', name: 'products_delete')]
    public function delete(ProductRepository $productRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $product = $productRepository->find($id);
        $nomImg = $product->getImg();
        if ($nomImg !== null) {
            $cheminImg = $this->getParameter('dossier_img') . '/' . $nomImg;
            if (file_exists($cheminImg)) {
                unlink($cheminImg);
            }
        }
        
        $manager = $managerRegistry->getManager();
        $manager->remove($product);
        $manager->flush();
        $this->addFlash('success', 'Le produit a bien été supprimé');
        return $this->redirectToRoute('admin_products_index');
    }

}
