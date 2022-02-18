<?php

namespace App\Controller;

use App\Entity\Types;
use App\Form\TypesType;
use App\Repository\TypesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypesController extends AbstractController
{
    #[Route('/admin/types', name: 'admin_types_index')]
    public function index(TypesRepository $typesRepository): Response
    {
        $types = $typesRepository->findAll();
        return $this->render('admin/types.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/admin/types/create', name: 'types_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $types = new Types();
        $form = $this->createForm(TypesType::class, $types);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($types);
            $manager->flush();
            $this->addFlash('success', 'Le type a bien été ajouté');
            return $this->redirectToRoute('admin_types_index');
        }
        return $this->render('admin/typesForm.html.twig', [
            'typesForm' => $form->createView()
        ]);
    }

    #[Route('/admin/types/update/{id}', name: 'types_update')]
    public function update(TypesRepository $typesRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $types = $typesRepository->find($id);
        $form = $this->createForm(TypesType::class, $types);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($types);
            $manager->flush();
            $this->addFlash('success', 'Le type a bien été modifié');
            return $this->redirectToRoute('admin_types_index');
        }
            
        return $this->render('admin/typesForm.html.twig', [
            'typesForm' => $form->createView(),
            'types' => $types
        ]);
    }

    #[Route('/admin/types/delete/{id}', name: 'types_delete')]
    public function delete(TypesRepository $typesRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $types = $typesRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($types);
        $manager->flush();
        $this->addFlash('success', 'Le type a bien été supprimé');
        return $this->redirectToRoute('admin_types_index');
    }
}
