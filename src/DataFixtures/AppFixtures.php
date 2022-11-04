<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::Create('fr-FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $users = [];
        for($i=4; $i<20; $i++){
            $user = new User();
            $user->setPrenom($this->faker->firstName())
                ->setNom($this->faker->lastName())
                ->setAdresse($this->faker->address())
                ->setCodePostal($this->faker->postcode())
                ->setVille($this->faker->city())
                ->setTelephone($this->faker->phoneNumber())
                ->setEmail($this->faker->email())
                ->setPassword('symfony')
                ->setRoles(['ROLE_USER']);
                $users []= $user;
                $manager->persist($user);   
        }

        $projets = [];
        for($i=0; $i<25 ; $i++){
            $projet= new Projet();

            $projet->setTitre($this->faker->sentence(5))
                    ->setDescription($this->faker->text(15))
                    ->setCodePostal($this->faker->postcode())
                    ->setVille($this->faker->city())
                    ->setUser($users[mt_rand(4 , count($users)-1)]);
                    
                $projets[] = $projet;

            $manager->persist($projet);
        }

        $manager->flush();
    }
}
