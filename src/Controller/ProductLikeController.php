<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductLike;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class ProductLikeController extends AbstractController
{
    #[Route('like-unlike', name: 'front_product_like_unlike')]

    public function like(Request $request, ManagerRegistry $doctrine): Response
    {

        if ($request->getMethod() === 'POST' && $request->isXmlHttpRequest()) {
            $em = $doctrine->getManager();
            $productId = $request->request->get('entityId');
            $product = $em->getRepository(Product::class)->findOneBy(array('id' => $productId));

            if (!$product) {
                return new JsonResponse();
            }

            $submittedToken = $request->request->get('csrfToken');

            if ($this->isCsrfTokenValid('product' . $product->getId(), $submittedToken)) {
                $user = $this->getUser();
                $productAlreadyLiked = $em->getRepository(ProductLike::class)->findOneBy(array('user' => $user, 'product' => $product));

                if ($productAlreadyLiked) {
                    $em->remove($productAlreadyLiked);
                    $em->flush();
                    return new JsonResponse();
                } else {
                    $like = new ProductLike();
                    $like->setUser($user);
                    $like->setProduct($product);
                    $em->persist($like);
                    $em->flush();
                }
            }
        }
        return  new JsonResponse();
       }
}
