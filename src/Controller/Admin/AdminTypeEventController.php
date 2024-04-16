<?php

namespace App\Controller\Admin;

use App\Entity\TypeEvent;
use App\Form\TypeEventType;
use App\Repository\TypeEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/typeevent', name: 'admin.typeevent.')]
#[isGranted('ROLE_ADMIN')]
class AdminTypeEventController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TypeEventRepository $repository): Response
    {
        $typeEvents = $repository->findAll();
        return $this->render('back/typeevent/index.html.twig', [
            'type_events' => $typeEvents,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $typeEvent = new TypeEvent();
        $form = $this->createForm(TypeEventType::class, $typeEvent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($typeEvent);
            $em->flush();
            $this->addFlash('success', "Le type d'événement a bien été ajouté");
            return $this->redirectToRoute('admin.typeevent.index');
        }
        return $this->render('back/typeevent/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(TypeEvent $typeEvent, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TypeEventType::class, $typeEvent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', "Le type d'événement a bien été modifié");
            return $this->redirectToRoute('admin.typeevent.index');
        }
        return $this->render('back/typeevent/edit.html.twig', [
            'form' => $form,
            'typeevent' => $typeEvent
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(TypeEvent $typeEvent, EntityManagerInterface $em)
    {
        $em->remove($typeEvent);
        $em->flush();
        $this->addFlash('success', "Le type d'événement a bien été supprimé");
        return $this->redirectToRoute('admin.typeevent.index');
    }
}
