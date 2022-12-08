<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ProductType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/products/create')]
    public function create(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $article = new Article();
        $form = $this->createForm(ProductType::class, $article);
        $date = new DateTime();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if($imageFile){
                $image= $fileUploader->upload($imageFile);
                $article->setImage($image);
            }


            if ($article->getReleaseDate() > $date) {
                $article->setIsReleased(false);
            } else {
                $article->setIsReleased(true);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            
        }

        return $this->render("products/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
