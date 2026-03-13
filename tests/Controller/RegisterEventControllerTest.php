<?php

namespace App\Tests\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterEventControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $eventRepository = $client->getContainer()->get('doctrine')->getRepository(Event::class);
        $event = $eventRepository->findOneBy([]); // [] = aucun critère → premier trouvé

        $this->assertNotNull($event, 'Aucun événement trouvé dans la base de test');

        $eventId = $event->getId();
        $client->request('GET', '/event/' . $eventId);

        $this->assertResponseIsSuccessful();
    }
}
