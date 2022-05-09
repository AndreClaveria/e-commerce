<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($product = 1; $product <= 10; $product++) {
            $products = new Produit();
            $products->setNom($faker->text(5));
            $products->setDescription($faker->text());
            $products->setPrix($faker->numberBetween(0, 1000));
            $products->setSlug($this->slugger->slug($products->getNom())->lower());
            $products->setImage($faker->image(null, 640, 480));
            $category = $this->getReference('cat-'.rand(1, 5));
            $products->setCategorie($category);
            $user = $this->getReference('user-'.rand(1, 4));
            $products->setUser($user);
            $manager->persist($products);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class
        ];  
    }
}
