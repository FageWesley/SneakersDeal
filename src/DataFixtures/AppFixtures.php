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
        $images=["https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg","https://cdn.pixabay.com/photo/2013/05/12/18/55/balance-110850__340.jpg","https://cdn.pixabay.com/photo/2017/10/17/16/10/fantasy-2861107__340.jpg","https://cdn.pixabay.com/photo/2017/12/11/15/34/lion-3012515__340.jpg","https://cdn.pixabay.com/photo/2012/02/24/16/59/swan-16736__340.jpg","https://cdn.pixabay.com/photo/2017/10/26/12/34/fantasy-2890925__340.jpg","https://cdn.pixabay.com/photo/2013/06/20/13/52/world-140304__340.jpg","https://cdn.pixabay.com/photo/2012/01/09/09/48/earth-11593__340.jpg"];
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product
                ->setTitle('Product ' . $i)
                ->setImage($images[array_rand($images)])
                ->setPrice(mt_rand(10, 600))
                ->setIsReleased(0)
                ->setReleaseDate(new DateTime("2023-01-01"));

            $manager->persist($product);
        }
        

        $manager->flush();
    }
}
