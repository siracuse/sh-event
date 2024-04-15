<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/user', name: 'admin.user.')]
#[isGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('back/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('notice', "L'utilisateur a bien été modifié");
            return $this->redirectToRoute('admin.user.index');
        }
        return $this->render('back/user/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();
        $this->addFlash('notice', "L'utilisateura bien été supprimé");
        return $this->redirectToRoute('admin.user.index');
    }
}
