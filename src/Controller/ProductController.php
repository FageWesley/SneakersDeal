<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddToCartType;
use App\Form\ProductType;
use App\Manager\CartManager;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/create')]
    public function create(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $date = new DateTime();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if($imageFile){
                $image= $fileUploader->upload($imageFile);
                $product->setImage($image);
            }


            if ($product->getReleaseDate() > $date) {
                $product->setIsReleased(false);
            } else {
                $product->setIsReleased(true);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            
        }

        return $this->render("products/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route("/product/{id}", name:"product.detail")]
    
    public function detail(Product $product, Request $request, CartManager $cartManager)
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduct($product);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new DateTimeImmutable());

            $cartManager->save($cart);

            return $this->redirectToRoute('product.detail', ['id' => $product->getId()]);
        }

        return $this->render('products/product.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
