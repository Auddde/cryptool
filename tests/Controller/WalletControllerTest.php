<?php

namespace App\tests\Security;

use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class WalletControllerTest extends WebTestCase
{

    public function testAddWallet()
    {
        // Simule un faux navigateur
        $client = static::createClient();

        // Crée mon user de test
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marc@gmail.com');

        // simulate l'action de login
        $client->loginUser($testUser);

        // Atteint la page portefeuille
        $client->request('GET', 'http://cryptool.localhost/portefeuille');
        $crawler = $client->request('GET', 'http://cryptool.localhost/portefeuille');

        // Récupère le lien d'ajout de portefeuille et clique
        $addLink = $crawler->filter('#addwallet_link')->link();
        $client->click($addLink);

        $this->assertSelectorTextContains('h1', 'Ajouter un portefeuille');

        // Se positionne sur la page d'ajout de portefeuille
        $crawler = $client->request('GET', 'http://cryptool.localhost/portefeuille/add');

        //Rempli les données du formulaire
        $form = $crawler->selectButton("Ajouter")->form();
        $form["wallet[name]"] = 'Mon nouveau portefeuille';
        $form["wallet[description]"] = 'Ceci est mon nouveau portefeuille ainsi que ça description, en esperant ne pas le perdre';
        $form["wallet[walletcategory]"] = 1;

        $client->submit($form);

        // Redirige et affiche le Flashmessage
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('#flash-validation')->count());

    }

    public function testEditWallet() {
        // Simule un faux navigateur
        $client = static::createClient();

        // Crée mon user de test
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marc@gmail.com');

        //Choisi une wallet de ce user
        $walletRepository = static::getContainer()->get(WalletRepository::class);
        $testWallet = $walletRepository->findOneBy(['user' => $testUser->getId()]);

        // simule l'action de login
        $client->loginUser($testUser);

        // Atteint la page d'edition
        $client->request('GET', 'http://cryptool.localhost/portefeuille/'.$testWallet->getUuid().'/edit');
        $crawler = $client->request('GET', 'http://cryptool.localhost/portefeuille/'.$testWallet->getUuid().'/edit');
        $this->assertSelectorTextContains('h1', 'Modifier le portefeuille');

        //Rempli les données du formulaire
        $form = $crawler->selectButton("Modifier")->form();
        $form["wallet[name]"] = 'Mon nouveau portefeuille edité';
        $form["wallet[description]"] = 'Ceci est mon nouveau portefeuille que je viens de modifier ainsi que ça description, en esperant ne pas le perdre';
        $form["wallet[walletcategory]"] = 2;

        $client->submit($form);

        // Redirige et affiche le Flashmessage
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('#flash-validation')->count());

    }

    public function testRemoveTransaction() {

        // Simule un faux navigateur
        $client = static::createClient();

        // Crée mon user de test
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marc@gmail.com');

        //Choisi une transaction de ce user
        $walletRepository = static::getContainer()->get(WalletRepository::class);
        $testWallet = $walletRepository->findOneBy(['user' => $testUser->getId()]);

        // simule l'action de login
        $client->loginUser($testUser);

        // Atteint la page concerner
        $client->request('GET', 'http://cryptool.localhost/portefeuille/'.$testWallet->getUuid().'/edit');
        $crawler = $client->request('GET', 'http://cryptool.localhost/portefeuille/'.$testWallet->getUuid().'/edit');

        //Soumet le formulaire de suppression
        $form = $crawler->selectButton("btnremove-action")->form();
        $client->submit($form);

        // Redirige et affiche le Flashmessage
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('#flash-validation')->count());
    }

}