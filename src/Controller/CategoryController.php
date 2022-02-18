<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'admin_category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        return $this->render('admin/category.html.twig', [
            'categories' => $category,
        ]);
    }

    #[Route('/admin/category/create', name: 'category_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'Le type a bien été ajouté');
            return $this->redirectToRoute('admin_category_index');
        }
        return $this->render('admin/categoryForm.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    #[Route('/admin/category/update/{id}', name: 'category_update')]
    public function update(CategoryRepository $categoryRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $category = $categoryRepository->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'Le type a bien été modifié');
            return $this->redirectToRoute('admin_category_index');
        }
            
        return $this->render('admin/categoryForm.html.twig', [
            'categoryForm' => $form->createView(),
            'categories' => $category
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'category_delete')]
    public function delete(CategoryRepository $categoryRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $category = $categoryRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($category);
        $manager->flush();
        $this->addFlash('success', 'Le type a bien été supprimé');
        return $this->redirectToRoute('admin_category_index');
    }
}
