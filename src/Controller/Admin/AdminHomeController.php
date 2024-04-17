<?php

namespace App\Controller\Admin;

use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[isGranted('ROLE_ADMIN')]
class AdminHomeController extends AbstractController
{
    #[Route('/admin', name: 'admin.index')]
    public function index(UserRepository $userRepository, EventRepository $eventRepository): Response
    {
        $allEvents = count($eventRepository->getAllEventByStatus('valid'));
        $allEventsWaiting = count($eventRepository->getAllEventByStatus('waiting'));
        $allUsers = count($userRepository->findAll());
        return $this->render('back/index.html.twig', [
            'allEvents' => $allEvents,
            'allEventsWaiting' => $allEventsWaiting,
            'allUsers' => $allUsers
        ]);
    }
}
