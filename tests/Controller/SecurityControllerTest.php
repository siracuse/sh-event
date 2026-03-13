<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin200()
    {
        $client = static::createClient();
        $client->request('GET', '/login'); 

        $this->assertResponseIsSuccessful();
    }

}