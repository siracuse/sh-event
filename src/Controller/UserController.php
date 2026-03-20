<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class UserController extends AbstractController
{
    #[Route('/user', name: 'myProfil')]
    public function myProfil(): Response
    {
        $user = $this->getUser();
        return $this->render('front/myProfil.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/user/{id}', name: 'userProfil')]
    public function userProfil(UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        return $this->render('front/profil.html.twig', [
            'user' => $user
        ]);
    }
}
