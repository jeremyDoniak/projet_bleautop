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
    #[Route('/profile', name: 'profile_index')]
    public function index(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/user', name: 'profile')]
    public function profile(UserRepository $userRepository): Response
    {
        $user = $userRepository->find($this->getUser());
        return $this->render('/profile/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/user/create', name: 'profile_create')]
    public function createUser(Request $request, ManagerRegistry $managerRegistry)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été ajouté');
            return $this->redirectToRoute('profile_index');
        }
        return $this->render('profile/userForm.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/profile/user/update/{id}', name: 'profile_update')]
    public function updateUser(UserRepository $userRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('profile_index');
        }
            
        return $this->render('profile/userForm.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/profile/user/delete/{id}', name: 'profile_delete')]
    public function deleteUser(UserRepository $userRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('profile_index');
    }

    /**************** ADMIN CONTROL ********************/

    #[Route('/admin/user', name: 'admin_user_index')]
    public function utilisateurs(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        return $this->render('admin/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/user/create', name: 'admin_user_create')]
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

    #[Route('/admin/user/update/{id}', name: 'admin_user_update')]
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

    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete')]
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
