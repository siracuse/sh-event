<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[isGranted('ROLE_ADMIN')]
class AdminHomeController extends AbstractController
{
    #[Route('/admin', name: 'admin.index')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig');
    }
}
