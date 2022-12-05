<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SneakersDealController extends AbstractController
{
    #[Route('/', name: 'app_sneakers_deal')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Article::class);
        $list = $articles->findAll();
        return $this->render('sneakers_deal/index.html.twig', [
            'list' =>  $list
        ]);
    }
    #[Route('/drops', name:"drops")]
    public function drops(ManagerRegistry $doctrine)
    {
        $articles = $doctrine->getRepository(Article::class);
        $list = $articles->findBy(array("isReleased" =>'0'));
        return $this->render('sneakers_deal/drops.html.twig',[
            'list' => $list
        ]);
    }   
}
