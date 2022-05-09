<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture 
{
    private $counter;
    
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger ){}

    
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@ecommerce.com');
        $admin->setPseudo('Admin');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin1')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        
        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 5; $usr++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPseudo($faker->firstName);
            $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'secret1'));
            $user->setRoles(['ROLE_USER']);
            $this->addReference('user-'.$this->counter, $user);
            $this->counter++;
            $manager->persist($user);
        }
        $manager->flush();
    }

    

    
}
