<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    
    #[Route('/profile/{id}', name:'profile_show')]
    public function showProfil(User $user)
    {
        return $this->render('profile/profileShow.html.twig', [
            'user' => $user
        ]);
    }
    
    #[Route('/profile', name:'profile')]
    public function showProduct(ProduitRepository $repo)
    {
        $produits = $repo->findAll();
        return $this->render('profile/profile.html.twig', [
            'produits' => $produits,
        ]);
    }


}
