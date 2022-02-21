<?php

namespace App\Controller;

use App\Entity\Size;
use App\Form\SizeType;
use App\Repository\SizeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SizeController extends AbstractController
{
    #[Route('/admin/size', name: 'admin_size_index')]
    public function index(SizeRepository $sizeRepository): Response
    {
        $size = $sizeRepository->findAll();
        return $this->render('admin/size.html.twig', [
            'sizes' => $size,
        ]);
    }

    #[Route('/admin/size/create', name: 'size_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $size = new Size();
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($size);
            $manager->flush();
            $this->addFlash('success', 'La taille a bien été ajoutée');
            return $this->redirectToRoute('admin_size_index');
        }
        return $this->render('admin/sizeForm.html.twig', [
            'sizeForm' => $form->createView()
        ]);
    }

    #[Route('/admin/size/update/{id}', name: 'size_update')]
    public function update(SizeRepository $sizeRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $size = $sizeRepository->find($id);
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($size);
            $manager->flush();
            $this->addFlash('success', 'La taille a bien été modifiée');
            return $this->redirectToRoute('admin_size_index');
        }
            
        return $this->render('admin/sizeForm.html.twig', [
            'sizeForm' => $form->createView(),
            'sizes' => $size
        ]);
    }

    #[Route('/admin/size/delete/{id}', name: 'size_delete')]
    public function delete(SizeRepository $sizeRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $size = $sizeRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($size);
        $manager->flush();
        $this->addFlash('success', 'La taille a bien été supprimée');
        return $this->redirectToRoute('admin_size_index');
    }
}
