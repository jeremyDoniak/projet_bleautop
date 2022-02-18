<?php

namespace App\Controller;

use App\Entity\Angle;
use App\Form\AngleType;
use App\Repository\AngleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AngleController extends AbstractController
{
    #[Route('/admin/angle', name: 'admin_angle_index')]
    public function index(AngleRepository $angleRepository): Response
    {
        $angle = $angleRepository->findAll();
        return $this->render('admin/angle.html.twig', [
            'angles' => $angle,
        ]);
    }

    #[Route('/admin/angle/create', name: 'angle_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $angle = new Angle();
        $form = $this->createForm(AngleType::class, $angle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($angle);
            $manager->flush();
            $this->addFlash('success', 'Le type a bien été ajouté');
            return $this->redirectToRoute('admin_angle_index');
        }
        return $this->render('admin/angleForm.html.twig', [
            'angleForm' => $form->createView()
        ]);
    }

    #[Route('/admin/angle/update/{id}', name: 'angle_update')]
    public function update(AngleRepository $angleRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $angle = $angleRepository->find($id);
        $form = $this->createForm(AngleType::class, $angle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($angle);
            $manager->flush();
            $this->addFlash('success', 'Le type a bien été modifié');
            return $this->redirectToRoute('admin_angle_index');
        }
            
        return $this->render('admin/angleForm.html.twig', [
            'angleForm' => $form->createView(),
            'angles' => $angle
        ]);
    }

    #[Route('/admin/angle/delete/{id}', name: 'angle_delete')]
    public function delete(AngleRepository $angleRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $angle = $angleRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($angle);
        $manager->flush();
        $this->addFlash('success', 'Le type a bien été supprimé');
        return $this->redirectToRoute('admin_angle_index');
    }
}
