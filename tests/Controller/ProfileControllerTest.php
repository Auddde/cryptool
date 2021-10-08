<?php

namespace App\tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class ProfileControllerTest extends WebTestCase
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
        $crawler = $client->request('GET', 'http://cryptool.localhost/');

        // Récupère le lien pour atteindre le profil
        $profilLink = $crawler->filter('#profil_link')->link();
        $client->click($profilLink);

        // Vérifie que tout est OK
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Verifie le contenu
        $client->request('GET', 'http://cryptool.localhost/profil');
        $crawler = $client->request('GET', 'http://cryptool.localhost/profil');

        $this->assertSelectorTextContains('h1', 'Profil de Marc');
    }
}