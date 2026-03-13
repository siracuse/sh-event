<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testIndex200()
    {
        $client = static::createClient();
        $client->request('GET', '/'); 

        $this->assertResponseIsSuccessful();
    }

    // public function testRegister200()
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/event'); 

    //     $this->assertResponseIsSuccessful();
    // }

}