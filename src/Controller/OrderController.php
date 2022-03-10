<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order_index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        return $this->render('order/index.html.twig', [
            'orders' => $order,
        ]);
    }

    #[Route('/order/order/{id}', name: 'order')]
    public function order(OrderRepository $orderRepository, int $id): Response
    {
        $order = $orderRepository->find($id);
        return $this->render('/order/order.html.twig', [
            'orders' => $order,
        ]);
    }

    #[Route('/order/order/create', name: 'order_create')]
    public function createOrder(Request $request, ManagerRegistry $managerRegistry)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été ajouté');
            return $this->redirectToRoute('order_index');
        }
        return $this->render('order/orderForm.html.twig', [
            'orderForm' => $form->createView()
        ]);
    }

    #[Route('/order/order/update/{id}', name: 'order_update')]
    public function updateOrder(OrderRepository $orderRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $order = $orderRepository->find($id);
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($order);
            $manager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('order_index');
        }
            
        return $this->render('order/orderForm.html.twig', [
            'orderForm' => $form->createView(),
            'orders' => $order,
        ]);
    }

    #[Route('/order/order/delete/{id}', name: 'order_delete')]
    public function deleteOrder(OrderRepository $orderRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $order = $orderRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($order);
        $manager->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('order_index');
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
            $this->addFlash('success', 'L\'utilisateur a bien été ajouté');
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
            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
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
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('admin_order_index');
    }
}
