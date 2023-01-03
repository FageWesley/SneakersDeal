<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductLike;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends AbstractController
{
    #[Route('/wishlist', name: 'app_wishlist')]
    public function index(ManagerRegistry $doctrine, Request $request, ProductRepository $repo): Response
    {
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')->getData();
            $results = $repo->findProductByTitle($query);

            return $this->render('search/search_results.html.twig', [
                'results' => $results,
            ]);
        }

        $em = $doctrine->getManager();
        $productsLiked = $em->getRepository(ProductLike::class)->findAll();
        $products = [];
        foreach ($productsLiked as $item) {
           array_push($products, $em->getRepository(Product::class)->findBy(array('id'=>$item->getProduct())));
        }

        return $this->render('wishlist/index.html.twig', [
            'products' => $products,
            'productsLiked' =>$productsLiked,
            'search_form' => $form->createView(),
            
        ]);
    }
}
