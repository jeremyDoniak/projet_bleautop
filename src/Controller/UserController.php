<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    // #[Route('/user', name: 'user')]
    // public function index(): Response
    // {
    //     return $this->render('user/index.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }

    #[Route('/admin/user', name: 'admin_user_index')]
    public function utilisateurs(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        return $this->render('admin/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/user/create', name: 'user_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été ajouté');
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/userForm.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/admin/user/update/{id}', name: 'user_update')]
    public function update(UserRepository $userRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('admin_user_index');
        }
            
        return $this->render('admin/userForm.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'user_delete')]
    public function delete(UserRepository $userRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('admin_user_index');
    }
}
