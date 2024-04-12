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
#[isGranted('ROLE_ADMIN')]
class AdminEventController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('back/event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/view/{id}', name: 'view')]
    public function view(Event $event, EntityManagerInterface $em): Response
    {
        return $this->render('back/event/view.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event->setStatus('valider');
            $event->setOrganiser($user);
            $em->persist($event);
            $em->flush();
            $this->addFlash('notice', "L'événement a bien été ajoutée");
            return $this->redirectToRoute('admin.event.index');
        }
        return $this->render('back/event/new.html.twig', [
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
        return $this->render('back/event/edit.html.twig', [
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


    #[Route('/valid', name: 'valid.index')]
    public function valid(EventRepository $repository)
    {
        $events = $repository->getAllEventByStatus('valid');
        return $this->render('back/event/eventByStatus.html.twig', [
            'events' => $events,
            'title' => 'Les événements qui ont été validé ✅'
        ]);
    }

    #[Route('/refuse', name: 'refuse.index')]
    public function refuse(EventRepository $repository)
    {
        $events = $repository->getAllEventByStatus('refuse');
        return $this->render('back/event/eventByStatus.html.twig', [
            'events' => $events,
            'title' => 'Les événements qui ont été refusé ❌'
        ]);
    }

    #[Route('/waiting', name: 'waiting.index')]
    public function waiting(EventRepository $repository): Response
    {
        $events = $repository->getAllEventByStatus('waiting');
        return $this->render('back/event/eventByStatus.html.twig', [
            'events' => $events,
            'title' => 'Les événements qui sont mise en attente ⏳'
        ]);
    }





    //  TO CHANGE STATUS EVENT
    #[Route('/waiting/valid/{id}', name: 'waiting.valid')]
    public function waitingValid(Event $event, EntityManagerInterface $em): Response
    {
        $event->setStatus('valid');
        $em->flush();
        return $this->redirectToRoute('admin.event.waiting.index');
    }

    #[Route('/waiting/refuse/{id}', name: 'waiting.refuse')]
    public function waitingRefuse(Event $event, EntityManagerInterface $em): Response
    {
        $event->setStatus('refuse');
        $em->flush();
        return $this->redirectToRoute('admin.event.waiting.index');
    }


}
