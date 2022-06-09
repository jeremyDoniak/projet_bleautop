<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use App\Form\OrderType;
use App\Entity\OrderLine;
use App\Form\AddressType;
use App\Service\CartService;
use App\Form\UserAddressType;
use App\Repository\AddressRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddressController extends AbstractController
{
    #[Route('/admin/address', name: 'admin_address_index')]
    public function index(AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findAll();
        return $this->render('admin/address.html.twig', [
            'addresses' => $address,
        ]);
    }

    #[Route('/admin/address/create', name: 'admin_address_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('success', 'L\'adresse a bien été ajoutée');
            return $this->redirectToRoute('admin_address_index');
        }
        return $this->render('admin/addressForm.html.twig', [
            'addressForm' => $form->createView()
        ]);
    }

    #[Route('/admin/address/update/{id}', name: 'admin_address_update')]
    public function update(AddressRepository $addressRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $address = $addressRepository->find($id);
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('success', 'L\'adresse a bien été modifiée');
            return $this->redirectToRoute('admin_address_index');
        }
            
        return $this->render('admin/addressForm.html.twig', [
            'addressForm' => $form->createView(),
            'addresses' => $address
        ]);
    }

    #[Route('/admin/address/delete/{id}', name: 'admin_address_delete')]
    public function delete(AddressRepository $addressRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $address = $addressRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($address);
        $manager->flush();
        $this->addFlash('success', 'L\'adresse a bien été supprimée');
        return $this->redirectToRoute('admin_address_index');
    }

    /*************************** PROFILE **********************************/

    #[Route('/profile/addressSelect', name: 'profile_address_select')]
    public function selectUserAddress(Request $request, AddressRepository $addressRepository, cartService $cartService, ManagerRegistry $managerRegistry, SessionInterface $sessionInterface): Response
    {
        // $order = new Order();
        // $formAddressSelect = $this->createForm(OrderType::class, $order);
        // $formAddressSelect->handleRequest($request);

        // if ($formAddressSelect->isSubmitted() && $formAddressSelect->isValid()) {
        //     $order->setOrderDate(new \DateTime);
        //     $order->setUser($this->getUser());
        //     $order->setAmount($cartService->getTotal());
        //     $manager = $managerRegistry->getManager();

        //     $cart = $cartService->getCart();

        //     foreach ($cart as $item) {
        //         $orderLine = new OrderLine();
        //         $orderLine->setProduct($item['product']);
        //         $orderLine->setOrderNumber($order);
        //         $orderLine->setQuantity($item['quantity']);

        //         $manager->persist($orderLine);
        //     }

        //     $manager->persist($order);
        //     $sessionInterface->set('order', $order);
        //     $manager->flush();

        //     return $this->redirectToRoute('payment');
        // }

        $cart = $cartService->getCart();
        $address = $addressRepository->findBy(['user' => $this->getUser()]);

        return $this->render('profile/addressSelect.html.twig', [
            'addresses' => $address,
            'cart' => $cart,
            // 'formAddressSelected' => $formAddressSelect->createView(),

        ]);
    }

    #[Route('/profile/address', name: 'profile_address')]
    public function indexUserAddress(AddressRepository $addressRepository, cartService $cartService): Response
    {
        $cart = $cartService->getCart();
        $address = $addressRepository->findBy(['user' => $this->getUser()]);
        return $this->render('profile/address.html.twig', [
            'addresses' => $address,
            'cart' => $cart,
        ]);
    }

    #[Route('/profile/address/create', name: 'profile_address_create')]
    public function createUserAddress(Request $request, ManagerRegistry $managerRegistry, CartService $cartService)
    {
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
        $cart = $cartService->getCart();
        $address = new Address();
        $form = $this->createForm(UserAddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userId = $this->getUser();
            $address->setUser($userId);
            $manager = $managerRegistry->getManager();
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('success', 'L\'adresse a bien été ajoutée');
            return $this->redirect($referer);
        }
        return $this->render('profile/addressForm.html.twig', [
            'cart' => $cart,
            'addressForm' => $form->createView()
        ]);
    }

    #[Route('/profile/address/update/{id}', name: 'profile_address_update')]
    public function updateUserAddress(Request $request, ManagerRegistry $managerRegistry, AddressRepository $addressRepository, int $id, CartService $cartService)
    {
        $cart = $cartService->getCart();
        $address = $addressRepository->find($id);
        $form = $this->createForm(UserAddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('success', 'L\'adresse a bien été modifiée');
            return $this->redirectToRoute('profile_address');
        }
            
        return $this->render('profile/addressForm.html.twig', [
            'cart' => $cart,
            'addressForm' => $form->createView(),
            'addresses' => $address
        ]);
    }

    #[Route('/profile/address/delete/{id}', name: 'profile_address_delete')]
    public function deleteUserAddress(AddressRepository $addressRepository, ManagerRegistry $managerRegistry, int $id)
    {
        $address = $addressRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($address);
        $manager->flush();
        $this->addFlash('success', 'L\'adresse a bien été supprimée');
        return $this->redirectToRoute('profile_address');
    }
}
