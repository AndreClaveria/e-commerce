<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\RechercheType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ProduitRepository $repo, Request $request): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->get('recherche')->getData();
            $produit = $repo->getProduitsByName($data);
        }
        else
        {
            $produit = $repo->findAll();
        }
        
        return $this->render('main/index.html.twig', [
            'produit' => $produit,
            'formRecherche' =>$form->createView()
        ]);
    }

    #[Route('produit/show/{id}', name: 'details')]
    public function details(Produit $produit)
    {
        return $this->render('produit/details.html.twig', compact('produit'));
    }

    #[Route('/article/new', name:'article_create')]
    #[Route('/article/edit/{id}', name:"article_edit")]
    public function form(Request $request, EntityManagerInterface $manager, Produit $produit = null)
    {
        if(!$produit)
        {
            $user = $this->getUser();
            $produit = new Produit;
            $produit->setUser($user);
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        dump($produit);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute('details', [
                'id' => $produit->getId()
            ]);
        }

        return $this->render('produit/form.html.twig', [
            'editMode' => $produit->getId() !== null,
            'formProduit' => $form->createView()
        ]);
    }


}
