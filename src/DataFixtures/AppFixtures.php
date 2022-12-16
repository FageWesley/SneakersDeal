<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User($this->passwordHasher);
        $user->setUsername("Wesley")->setPassword("password")->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product
                ->setTitle('Product ' . $i)
                ->setImage('')
                ->setPrice(mt_rand(10, 600))
                ->setIsReleased(0)
                ->setReleaseDate(new DateTime("2023-01-01"));

            $manager->persist($product);
        }
        

        $manager->flush();
    }
}
