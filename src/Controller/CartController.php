<?php

namespace App\Controller;


use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService, ProductRepository $productRepository): Response
    {
        $cart = $cartService->getCart();
        $total = $cartService->getTotal();
        $latestProducts = $productRepository->findBy([], ['id' => 'DESC'], 3);
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'latestProducts' => $latestProducts
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Request $request, CartService $cartService, int $id): Response
    {
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
        $cartService->add($id);
        $this->addFlash('success', 'Le produit a bien été ajouté');
        return $this->redirect($referer);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(Request $request, CartService $cartService, int $id): Response
    {
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
        $cartService->remove($id);
        return $this->redirect($referer);
    }

    #[Route('/cart/delete/{id}', name: 'cart_delete')]
    public function delete(Request $request, CartService $cartService, int $id): Response
    {
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
        $cartService->delete($id);
        return $this->redirect($referer);
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(Request $request, CartService $cartService): Response
    {
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
        $cartService->clear();
        return $this->redirect($referer);
    }

    public function getNavCart(CartService $cartService): Response
    {
        return $this->render('cart/_navCart.html.twig', [
            'cart' => $cartService->getCart(),
            'total' => $cartService->getTotal()
        ]);
    }

}
