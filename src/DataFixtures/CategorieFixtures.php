<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorieFixtures extends Fixture implements DependentFixtureInterface
{
    private $counter;
    public function __construct(private SluggerInterface $slugger){}
    
    public function load(ObjectManager $manager): void
    {
        $this->createCategorie("Informatique", $manager);
        $this->createCategorie("Automobile", $manager);
        $this->createCategorie("Jeu Vidéo", $manager);
        $this->createCategorie("Sport", $manager);
        $this->createCategorie("Vêtements", $manager);
        $this->createCategorie("Animaux", $manager);

        $manager->flush();
    }

    public function createCategorie(string $name, ObjectManager $manager)
    {
        $categorie = new Categorie();
        $categorie->setTitre($name);
        $categorie->setSlug($this->slugger->slug($categorie->getTitre())->lower());
        $manager->persist($categorie);
        
        $this->addReference('cat-'.$this->counter, $categorie);
        
        $this->counter++;
        return $categorie;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];  
    }
}
