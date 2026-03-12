<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testLogin200()
    {
        $client = static::createClient();
        $client->request('GET', '/login'); 

        $this->assertResponseIsSuccessful();
    }

    public function testRegister200()
    {
        $client = static::createClient();
        $client->request('GET', '/register'); 

        $this->assertResponseIsSuccessful();
    }

}