<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EventRepository $repository, UserPasswordHasherInterface $hasher, EntityManagerInterface $em): Response
    {
        $events = $repository->findAll();
        return $this->render('front/index.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/event/{id}', name: 'event')]
    public function event(Event $event): Response
    {
        return $this->render('front/event.html.twig', [
            'event' => $event,
        ]);
    }
}
