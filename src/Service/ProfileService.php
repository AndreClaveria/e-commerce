<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class ProfileService
{
    private $repo;
    private $rs;
    // Injection de dépendances  hors d'un controller : constructeur
    public function __construct(ProduitRepository $repo, RequestStack $rs)
    {
        $this->repo = $repo;
        $this->rs = $rs;
    }
    public function add($id){
      // RequestStack est une classe qui contient la session
      $session = $this->rs->getSession();

      $cart = $session->get('cart', []);
      //si le produit existe déja 
      if (!empty($cart[$id]))
          $cart[$id]++;
      else
          $cart[$id] = 1;
      // je récupère l'attribut de session 'cart' s'il existe, ou un tableau vide

      $session->set('cart', $cart);
      // je sauvegarde l'état de mon panier en session a l'attribut de session 'cart'

      // dd($session->get('cart'));
      // dd( = dump & die : afficher des infos et tuer l'exécution du code)
    }

    public function remove($id){
    
    $session = $this->rs->getSession();
    $cart = $session->get('cart', []);

    // si l'id existe dans mon panier, je le supprime du tableau via unset()
    if (!empty($cart[$id]))
        unset($cart[$id]);

    $session->set('cart', $cart);
}
    public function getCartWithData(){
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);
        $qt = 0;
   
        $cartWithData = [];

        // $cartWithData est un tableau multidimensionnel : chaque case est un tableau de 2 cases

            foreach ($cart as $id => $quantity) 
            {
                $cartWithData[] = [
                    'product' => $this->repo->find($id),
                    'quantity' => $quantity
                ];
                $qt += $quantity;
            }
            $session->set('qt', $qt);
            return $cartWithData;
    }

}
