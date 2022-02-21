<?php

namespace App\Controller;

use App\Entity\Drilling;
use App\Form\DrillingType;
use App\Repository\DrillingRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DrillingController extends AbstractController
{
    #[Route('/admin/drilling', name: 'admin_drilling_index')]
    public function index(DrillingRepository $drillingRepository): Response
    {
        $drilling = $drillingRepository->findAll();
        return $this->render('admin/drilling.html.twig', [
            'drillings' => $drilling,
        ]);
    }

    #[Route('/admin/drilling/create', name: 'drilling_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $drilling = new Drilling();
        $form = $this->createForm(DrillingType::class, $drilling);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($drilling);
            $manager->flush();
            $this->addFlash('success', 'La trâme a bien été ajoutée');
            return $this->redirectToRoute('admin_drilling_index');
        }
        return $this->render('admin/drillingForm.html.twig', [
            'drillingForm' => $form->createView()
        ]);
    }

    #[Route('/admin/drilling/update/{id}', name: 'drilling_update')]
    public function update(DrillingRepository $drillingRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $drilling = $drillingRepository->find($id);
        $form = $this->createForm(DrillingType::class, $drilling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($drilling);
            $manager->flush();
            $this->addFlash('success', 'La trâme a bien été modifiée');
            return $this->redirectToRoute('admin_drilling_index');
        }
            
        return $this->render('admin/drillingForm.html.twig', [
            'drillingForm' => $form->createView(),
            'drillings' => $drilling
        ]);
    }

    #[Route('/admin/drilling/delete/{id}', name: 'drilling_delete')]
    public function delete(DrillingRepository $drillingRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $drilling = $drillingRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($drilling);
        $manager->flush();
        $this->addFlash('success', 'La trâme a bien été supprimée');
        return $this->redirectToRoute('admin_drilling_index');
    }
}
