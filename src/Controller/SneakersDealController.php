<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Service\Search;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SneakersDealController extends AbstractController
{
    #[Route('/', name: 'app_sneakers_deal')]
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

        $products = $doctrine->getRepository(Product::class);
        $productsList = $products->findAll();
        $drops = $products->findBy(array('isReleased' => 0));
        return $this->render('sneakers_deal/index.html.twig', [
            'drops' =>  $drops,
            'products' => $productsList,
            'search_form' => $form->createView(),

        ]);
    }
    #[Route('/drops', name: "drops")]
    public function drops(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("isReleased" => '0'));
        return $this->render('sneakers_deal/drops.html.twig', [
            'list' => $list
        ]);
    }

    #[Route('/nike', name: "nike")]
    public function Nike(ManagerRegistry $doctrine, Request $request, ProductRepository $repo)
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

        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand" => "Nike"));
        return $this->render('sneakers_deal/brand.html.twig', [
            'list' => $list,
            'search_form' => $form->createView(),
        ]);
    }

    #[Route('/adidas', name: "adidas")]
    public function Adidas(ManagerRegistry $doctrine, Request $request, ProductRepository $repo)
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
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand" => "Adidas"));
        return $this->render('sneakers_deal/brand.html.twig', [
            'list' => $list,
            'search_form' => $form->createView(),
        ]);
    }

    #[Route('/jordan', name: "jordan")]
    public function Jordan(ManagerRegistry $doctrine, Request $request, ProductRepository $repo)
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
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand" => "Jordan"));
        return $this->render('sneakers_deal/brand.html.twig', [
            'list' => $list,
            'search_form' => $form->createView(),
        ]);
    }

    #[Route('/new_balance', name: "new-balance")]
    public function NewBalance(ManagerRegistry $doctrine, Request $request, ProductRepository $repo)
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
        $products = $doctrine->getRepository(Product::class);
        $list = $products->findBy(array("brand" => "New_balance"));
        return $this->render('sneakers_deal/brand.html.twig', [
            'list' => $list,
            'search_form' => $form->createView(),
        ]);
    }
}
