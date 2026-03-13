<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{

    public function testRegister200()
    {
        $client = static::createClient();
        $client->request('GET', '/register'); 

        $this->assertResponseIsSuccessful();
    }

}