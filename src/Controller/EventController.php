<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('index.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/event/{id}', name: 'event')]
    public function event(Event $event): Response
    {
        return $this->render('event/index.html.twig', [
            'event' => $event,
        ]);
    }
}
