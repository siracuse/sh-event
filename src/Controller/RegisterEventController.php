<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\TakePart;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\TakePartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[isGranted('ROLE_USER')]
class RegisterEventController extends AbstractController
{

    #[Route('/register/event/{id}', name: 'event.participation.register')]
    public function registerParticipationEvent(Event $event, EntityManagerInterface $em, TakePartRepository $repository): Response
    {
        $user = $this->getUser();
        $take_part = $repository->findOneBy(['user' => $user->getId(), 'event' => $event->getId()]);

        if(!$take_part) {
            $newTake_part = new TakePart();
            $newTake_part->setEvent($event);
            $newTake_part->setUser($user);
            $newTake_part->setRegistrationStatus('valider');
            $em->persist($newTake_part);
            $em->flush();
            return $this->redirectToRoute('event', ['id' => $event->getId()]);
        } else {
            return $this->redirectToRoute('event.participation.list');
        }
    }

    #[Route('/event/remove_participation_event/{id}', name: 'event.participation.remove')]
    public function removeParticipationEvent(Event $event, EntityManagerInterface $em, TakePartRepository $repository): Response
    {
        $user = $this->getUser();
        $take_part = $repository->findOneBy(['user' => $user->getId(), 'event' => $event->getId()]);

        $em->remove($take_part);
        $em->flush();

        return $this->redirectToRoute('event', ['id' => $event->getId()]);
    }


    #[Route('/myevents', name: 'event.participation.list')]
    public function myEvents(TakePartRepository $repository ): Response
    {
        $user = $this->getUser();
        $allEvents = $repository->getAllEventByUser($user->getId());

        return $this->render('front/myevents.html.twig', [
            'allEvents' => $allEvents
        ]);
    }

    #[Route('/new/event', name: 'new.event')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $event->setOrganiser($user);
            $event->setStatus('waiting');
            $em->persist($event);
            $em->flush();
            $this->addFlash('success', "L'événement a bien été ajoutée");
            return $this->redirectToRoute('myevent.waiting');
        }
        return $this->render('front/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/myevents/waiting', name: 'myevent.waiting')]
    public function myEventWaiting(EventRepository $repository): Response
    {
        $user = $this->getUser();
        $eventsWaiting = $repository->getEventByStatusAndUser('waiting', $user);
        $eventsRefuse = $repository->getEventByStatusAndUser('refuse', $user);

        return $this->render('front/myeventswaiting.html.twig', [
            'eventsWaiting' => $eventsWaiting,
            'eventsRefuse' => $eventsRefuse
        ]);
    }


}