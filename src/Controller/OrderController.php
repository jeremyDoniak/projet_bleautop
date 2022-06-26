<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderLine;
use App\Service\CartService;
use App\Form\OrderAddressType;
use App\Repository\OrderRepository;
use App\Repository\OrderLineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/profile/order', name: 'profile_order')]
    public function index(OrderRepository $orderRepository, CartService $cartService): Response
    {
        $cart = $cartService->getCart();
        $order = $orderRepository->findBy(['user' => $this->getUser()]);
        return $this->render('profile/order.html.twig', [
            'orders' => $order,
            'cart' => $cart,
        ]);
    }

    #[Route('/profile/orderLine/{id}', name: 'profile_order_line')]
    public function line(OrderLineRepository $orderLineRepository, OrderRepository $orderRepository, int $id): Response
    {
        $orderLine = $orderLineRepository->findBy(['order_number' => $id]);
        $order = $orderRepository->findOneBy(['id' => $id]);

        if ($order->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('profile/orderLine.html.twig', [
            'orderLines' => $orderLine,
            'orders' => $order,
        ]);
    }

    #[Route('/profile/orderRecap', name: 'profile_order_recap')]
    public function recap(Request $request, SessionInterface $sessionInterface, CartService $cartService, ManagerRegistry $managerRegistry): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderAddressType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setOrderDate(new \DateTime);
            $order->setUser($this->getUser());
            $order->setAmount($cartService->getTotal());
            $manager = $managerRegistry->getManager();

            $cart = $cartService->getCart();
            
            foreach ($cart as $item) {
                $orderLine = new OrderLine();
                $orderLine->setProduct($item['product']);
                $orderLine->setOrderNumber($order);
                $orderLine->setQuantity($item['quantity']);

                $manager->persist($orderLine);
            }
            
            $manager->persist($order);
            $sessionInterface->set('order', $order);
            $manager->flush();

            return $this->redirectToRoute('payment');
        }

        $cart = $cartService->getCart();

        return $this->render('profile/orderRecap.html.twig', [
            'carts' => $cart,
            'total' => $cartService->getTotal(),
            'form' => $form->createView()
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

    #[Route('/admin/orderLine/{id}', name: 'admin_order_line')]
    public function details(OrderLineRepository $orderLineRepository, OrderRepository $orderRepository, int $id): Response
    {
        $orderLine = $orderLineRepository->findBy(['order_number' => $id]);
        $order = $orderRepository->findOneBy(['id' => $id]);
        return $this->render('admin/orderLine.html.twig', [
            'orderLines' => $orderLine,
            'orders' => $order
        ]);
    }

    #[Route('/admin/order/create', name: 'admin_order_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order->setOrderDate(new \DateTime);
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
