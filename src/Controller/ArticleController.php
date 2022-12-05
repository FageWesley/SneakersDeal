<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $date = new DateTime();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($article->getReleaseDate() > $date) {
                $article->setIsReleased(false);
            } else {
                $article->setIsReleased(true);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            
        }

        return $this->render("article/index.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
