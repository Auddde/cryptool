<?php

namespace App\tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class FrontControllerTest extends WebTestCase
{

    public function testDisplayIsUp()
    {
        // Simule un faux navigateur
        $client = static::createClient();

        // Crée mon user de test
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marc@gmail.com');

        // simulate l'action de login
        $client->loginUser($testUser);

        // Atteint la home page
        $client->request('GET', 'http://cryptool.localhost/');

        // Vérifie que tout est OK
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}