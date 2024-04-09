<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\TakePart;
use App\Repository\TakePartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[isGranted('ROLE_USER')]
class RegisterEventController extends AbstractController
{

    #[Route('/register/event/{id}', name: 'event.register')]
    public function index(Event $event, EntityManagerInterface $em): Response
    {

        $take_part = new TakePart();
        $take_part->setEvent($event);
        $take_part->setUser($this->getUser());
        $take_part->setRegistrationStatus('valider');
        $em->persist($take_part);
        $em->flush();

//        return $this->render('register_event/index.html.twig', [
//            'controller_name' => 'RegisterEventController',
//        ]);
        return $this->redirectToRoute('index');
    }

    #[Route('/myevents', name: 'event.user.list')]
    public function myEvents(TakePartRepository $repository): Response
    {
        $user = $this->getUser();
        $allEvents = $repository->getAllEventByUser($user->getId(), );
//        dd($allEvents);

        return $this->render('front/myevents.html.twig', [
            'allEvents' => $allEvents
        ]);
    }
}
