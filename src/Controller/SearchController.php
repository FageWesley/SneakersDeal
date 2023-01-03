<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Form\SortType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/research', name: 'app_research')]
    public function searchAction(ProductRepository $repo)
    {
        $sortForm = $this->createForm(SortType::class,[
            'action' => $this->redirectToRoute('app_sorted'),
            'method' => 'POST'

        ]);
        $query = 'air';
        $results = $repo->findProductByTitle($query);

        return $this->render('search/search_results.html.twig', [
            'results' => $results,
            'form' =>$sortForm->createView()
        ]);
    }
    #[Route('/sorted', name: 'app_sorted')]
    public function sortedProducts(Request $request, ProductRepository $repo)
    {
        $data = $request->request->all();
        $data2 = $data['sort'];
        $condition = $data2["sort"];
        $find = $repo->sortByPrice($condition);

        return $this->render("search/sorted.html.twig", [
            "sorted" => $find,
            'condition' => $condition
        ]);
    }
}
     
