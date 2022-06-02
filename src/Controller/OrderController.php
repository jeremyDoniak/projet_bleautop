<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/profile/order', name: 'profile_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findBy(['user' => $this->getUser()]);;
        return $this->render('profile/order.html.twig', [
            'orders' => $order,
        ]);
    }


    /**************** ADMIN CONTROL ********************/

    #[Route('/admin/order', name: 'admin_order_index')]
    public function utilisateurs(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        return $this->render('admin/order.html.twig', [
            'orders' => $order,
        ]);
    }

    #[Route('/admin/order/create', name: 'admin_order_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success', 'La commande a bien été ajoutée');
            return $this->redirectToRoute('admin_order_index');
        }
        return $this->render('admin/orderForm.html.twig', [
            'orderForm' => $form->createView()
        ]);
    }

    #[Route('/admin/order/update/{id}', name: 'admin_order_update')]
    public function update(OrderRepository $orderRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $order = $orderRepository->find($id);
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success', 'La commande a bien été modifiée');
            return $this->redirectToRoute('admin_order_index');
        }
            
        return $this->render('admin/orderForm.html.twig', [
            'orderForm' => $form->createView(),
            'orders' => $order,
        ]);
    }

    #[Route('/admin/order/delete/{id}', name: 'admin_order_delete')]
    public function delete(OrderRepository $orderRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $order = $orderRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($order);
        $manager->flush();
        $this->addFlash('success', 'La commande a bien été supprimée');
        return $this->redirectToRoute('admin_order_index');
    }
}
