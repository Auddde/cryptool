<?php

namespace App\tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class UserAuthentificatorTest extends WebTestCase
{

    public function testLoginLogout()
    {
        // Simule un faux navigateur
        $client = static::createClient();

        // Crée mon user de test
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marc@gmail.com');

        // simulate l'action de login
        $client->loginUser($testUser);

        // Vérifie le profil
        $client->request('GET', 'http://cryptool.localhost/profil');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Profil de Marc');

        // Vérifie le contenu de la page
        $crawler = $client->request('GET', 'http://cryptool.localhost/profil');

        // Récupère le lien via son ID (car lien sur une icone) et clique
        $logoutLink = $crawler->filter('#logout_icon')->link();
        $client->click($logoutLink);

        // Es redirigé vers la homepage
        $crawler = $client->followRedirect();

        // Es redirigé vers la page login
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Se connecter');

    }


}