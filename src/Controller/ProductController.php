<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductLike;
use App\Form\AddToCartType;
use App\Form\ProductType;
use App\Manager\CartManager;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
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
            if ($imageFile) {
                $image = $fileUploader->upload($imageFile);
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

    #[Route("/product/{id}", name: "product.detail")]

    public function detail(Product $product, Request $request, CartManager $cartManager, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);
        $user = $this->getUser();
        $em = $doctrine->getManager();

        $isProductAlreadyLike = $em->getRepository(ProductLike::class)->countByProductAndUser($user, $product);


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
            'isProductAlreadyLiked' => $isProductAlreadyLike,
            'form' => $form->createView()

        ]);
    }

    #[Route("/products/all", name: "all_products")]
    public function all_products(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $all_products = $em->getRepository(Product::class)->findAll();

        return $this->render("sneakers_deal/all_products.html.twig", [
            'products' => $all_products
        ]);
    }
}
