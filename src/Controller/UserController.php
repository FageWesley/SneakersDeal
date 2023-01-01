<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateAccountType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\PlaintextPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return  $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            "error" => $error
        ]);
    }

    #[Route('/registration', name: 'registration')]
    public function create(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User($passwordHasher);
        $form = $this->createForm(CreateAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }
}
