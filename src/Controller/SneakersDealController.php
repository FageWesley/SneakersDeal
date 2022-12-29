<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SneakersDealController extends AbstractController
{
    #[Route('/', name: 'app_sneakers_deal')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class);
        $productsList = $products->findAll();
        $drops = $products->findBy(array('isReleased'=>0));
        return $this->render('sneakers_deal/index.html.twig', [
            'drops' =>  $drops,
            'products' => $productsList,
        ]);
    }
    #[Route('/drops', name:"drops")]
    public function drops(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("isReleased" =>'0'));
        return $this->render('sneakers_deal/drops.html.twig',[
            'list' => $list
        ]);
    }  
    
    #[Route('/nike' ,name:"nike")]
    public function Nike(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand"=> "Nike"));
        return $this->render('sneakers_deal/brand.html.twig',[
            'list' => $list
        ]);
    }
    
    #[Route('/adidas' ,name:"adidas")]
    public function Adidas(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand"=> "Adidas"));
        return $this->render('sneakers_deal/brand.html.twig',[
            'list' => $list
        ]);
    }
    
    #[Route('/jordan' ,name:"jordan")]
    public function Jordan(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand"=> "Jordan"));
        return $this->render('sneakers_deal/brand.html.twig',[
            'list' => $list
        ]);
    }
    
    #[Route('/new_balance' ,name:"new-balance")]
    public function NewBalance(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand"=> "New_balance"));
        return $this->render('sneakers_deal/brand.html.twig',[
            'list' => $list
        ]);
    }
    
}
