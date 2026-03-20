<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\TakePartRepository;
use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EventRepository $repository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $events = $repository->paginateEvent($page, $limit, 'valid');
        $maxPage = ceil($events->count() / $limit);
        $eventTypes = $repository->findAllTypes();
        return $this->render('front/index.html.twig', [
            'events' => $events,
            'eventTypes' => $eventTypes,
            'maxPages' => $maxPage,
            'page' => $page,
        ]);
    }

    #[Route('/event/{id}', name: 'event')]
    public function event(Event $event, TakePartRepository $repository): Response
    {
        $isAlreadyTakePart = false;
        $user = $this->getUser();
        $getAllUserByEvent = $repository->getAllUserByEvent($event->getId());
        if ($user) {
            $allEventIdByUser = $repository->getAllEventIdByUser($user->getId());
            foreach ($allEventIdByUser as $result) {
                if ($event->getId() == $result['id']) {
                    $isAlreadyTakePart = true;
                }
            }
        }

        return $this->render('front/event.html.twig', [
            'event' => $event,
            'isAlreadyTakePart' => $isAlreadyTakePart,
            'getAllUserByEvent' => count($getAllUserByEvent),
        ]);
    }

    #[Route('/event/{id}/pdf', name: 'event.pdf')]
    public function eventPdf(Event $event, PdfGenerator $pdfGenerator): Response
    {
        $html = $this->renderView('front/pdf/event.html.twig', [
            'event' => $event,
        ]);

        $pdf = $pdfGenerator->generate($html);

        return new Response($pdf,200,['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="event.pdf"',]);
    }
}
