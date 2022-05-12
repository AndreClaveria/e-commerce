<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Category;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // l'objet $builder permet de construire un formulaire
        // add() permet d'ajouter un champ au formulaire
        $builder
            ->add('categorie', EntityType::class, [  // j'indique que le champ category est une entity
                'class' => Categorie::class, // je précise quelle entity
                'choice_label' => 'titre',
            ])
            
            ->add('nom', TextType::class, array(
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer le nom'
                    ])
                ]
            ))
            ->add('description', TextType::class, array(
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez écrire une description'
                    ])
                ]
            ))
            ->add('prix', TextType::class, array(
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer le prix'
                    ])
                ]
            ))
            ->add('image', TextType::class, array(
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez mettre une image'
                    ])
                ]
            ))
           ->add('slug', TextType::class, array(
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez un slug'
                ])
            ]
            ))
            
            
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
