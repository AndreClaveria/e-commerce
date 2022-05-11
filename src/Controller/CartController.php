<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cs->getCartWithData(), 
            'total' => $cs->getTotal()
        ]);
    }

    #[route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, CartService $cs){
        $cs->add($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/sub/{id}', name: 'cart_sub')]
    public function sub($id, CartService $cs){
        $cs->sub($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/empty/', name: 'cart_empty')]
    public function empty(CartService $cs)
    {
        $cs->empty();
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/paid/', name: 'cart_paid')]
    public function paid(CartService $cs)
    {
        $cs->empty();
        return $this->render('cart/paid.html.twig');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, CartService $cs)
    {
        $cs->remove($id);
        return $this->redirectToRoute('app_cart');
    }
}
