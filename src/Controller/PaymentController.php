<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Stripe\StripeClient;
use App\Service\CartService;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function index(Request $request, SessionInterface $sessionInterface, ProductRepository $productRepository): Response
    {
        $authorizedReferers = [
            'https://127.0.0.1:8000/cart',
            'https://127.0.0.1:8000/profile/addressSelect',
        ];
        if (!in_array($request->headers->get('referer'), $authorizedReferers)) {
            return $this->redirectToRoute('cart_index');
        }

        $cart = $sessionInterface->get('cart');
        $stripeCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            $stripeElement = [
                'amount' => $product->getPrice() * 100,
                'quantity' => $quantity,
                'currency' => 'EUR',
                'name' => $product->getName()
            ];
            $stripeCart[] = $stripeElement;
        }

        $stripe = new StripeClient('sk_test_51Kb3nfEdaID4l6dIt7lDnftn410Hzdk3fK5oO757BON3OofkvVceOdSxiJX8NUlnK8i52XvS7ZaKh8nCRpcuhy2O00cVf3NY28');

        $stripeSession = $stripe->checkout->sessions->create([
            'line_items' => $stripeCart,
            'mode' => 'payment',
            'success_url' => 'https://127.0.0.1:8000/payment/success',
            'cancel_url' => 'https://127.0.0.1:8000/payment/cancel',
            'payment_method_types' => ['card']
        ]);

        return $this->render('payment/index.html.twig', [
            'sessionId' => $stripeSession->id
        ]);
    }

    #[Route('/payment/success', name: 'payment_success')]
    public function success(Request $request, CartService $cartService, ManagerRegistry $managerRegistry, SessionInterface $sessionInterface, ProductRepository $productRepository): Response
    {
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);


        $manager = $managerRegistry->getManager();
        $manager->persist($order);
        $manager->flush();
        $this->addFlash('success', 'La commande a bien été ajoutée');
        $cartService->clear();
        return $this->render('payment/success.html.twig');

    }

    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function cancel(Request $request): Response
    {
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }
        return $this->render('payment/cancel.html.twig');
    }
}
