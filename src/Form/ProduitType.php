<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // l'objet $builder permet de construire un formulaire
        // add() permet d'ajouter un champ au formulaire
        $builder
            ->add('categorie', EntityType::class, [  // j'indique que le champ category est une entity
                'class' => Categorie::class, // je précise quelle entity
                'choice_label' => 'titre'
            ])
            
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('image')
            ->add('slug')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate' // désactive la validation html
            ],
            'data_class' => Produit::class,
        ]);
    }
}
