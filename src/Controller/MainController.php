<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ProduitRepository $repo): Response
    {
        $produit = $repo->findAll();
        return $this->render('main/index.html.twig', compact('produit'));
    }


}
