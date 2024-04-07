<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admin/event', name:'admin.event.')]
//#[isGranted('ROLE_ADMIN')]
class AdminEventController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('event/admin/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            $this->addFlash('notice', "L'événement a bien été ajoutée");
            return $this->redirectToRoute('admin.event.index');
        }
        return $this->render('event/admin/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('notice', "L'événement a bien été modifiée");
            return $this->redirectToRoute('admin.event.index');
        }
        return $this->render('event/admin/edit.html.twig', [
            'form' => $form,
            'event' => $event
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Event $event, EntityManagerInterface $em)
    {
        $em->remove($event);
        $em->flush();
        $this->addFlash('notice', "L'événement a bien été supprimée");
        return $this->redirectToRoute('admin.event.index');
    }
}
