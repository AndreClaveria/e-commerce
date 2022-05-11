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

    #[route('/cart/sub/{id}', name: 'cart_sub')]
    public function sub($id, CartService $cs){
        $cs->sub($id);
        return $this->redirectToRoute('app_cart');
    }



    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, CartService $cs)
    {
        $cs->remove($id);
        return $this->redirectToRoute('app_cart');
    }
}
