<?php

namespace App\Controller;

use App\Entity\Color;
use App\Form\ColorType;
use App\Repository\ColorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ColorController extends AbstractController
{
    #[Route('/admin/color', name: 'admin_color_index')]
    public function index(ColorRepository $colorRepository): Response
    {
        $color = $colorRepository->findAll();
        return $this->render('admin/color.html.twig', [
            'colors' => $color,
        ]);
    }

    #[Route('/admin/color/create', name: 'color_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $color = new Color();
        $form = $this->createForm(ColorType::class, $color);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($color);
            $manager->flush();
            $this->addFlash('success', 'La couleur a bien été ajoutée');
            return $this->redirectToRoute('admin_color_index');
        }
        return $this->render('admin/colorForm.html.twig', [
            'colorForm' => $form->createView()
        ]);
    }

    #[Route('/admin/color/update/{id}', name: 'color_update')]
    public function update(ColorRepository $colorRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $color = $colorRepository->find($id);
        $form = $this->createForm(ColorType::class, $color);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($color);
            $manager->flush();
            $this->addFlash('success', 'La couleur a bien été modifiée');
            return $this->redirectToRoute('admin_color_index');
        }
            
        return $this->render('admin/colorForm.html.twig', [
            'colorForm' => $form->createView(),
            'colors' => $color
        ]);
    }

    #[Route('/admin/color/delete/{id}', name: 'color_delete')]
    public function delete(ColorRepository $colorRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $color = $colorRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($color);
        $manager->flush();
        $this->addFlash('success', 'La couleur a bien été supprimée');
        return $this->redirectToRoute('admin_color_index');
    }
}
