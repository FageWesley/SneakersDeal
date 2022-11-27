<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SneakersDealController extends AbstractController
{
    #[Route('/', name: 'app_sneakers_deal')]
    public function index(): Response
    {
        return $this->render('sneakers_deal/index.html.twig', [
            'controller_name' => 'SneakersDealController',
        ]);
    }
}
