<?php

namespace App\tests\Security;

use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class TransactionControllerTest extends WebTestCase
{

    public function testAddTransaction()
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
        $crawler = $client->request('GET', 'http://cryptool.localhost/profil');

        // Récupère le lien d'ajout de transaction et clique
        $addLink = $crawler->filter('#add_link')->link();
        $client->click($addLink);

        $this->assertSelectorTextContains('h1', 'Ajouter une transaction');

        // Se positionne sur la page d'ajout de transaction
        $crawler = $client->request('GET', 'http://cryptool.localhost/add');

        //Rempli les données du formulaire
        $form = $crawler->selectButton("Ajouter")->form();
        $form["transaction[crypto]"] = 1;
        $form["transaction[quantity]"] = 5;
        $form["transaction[originalprice]"] = 3505.50;
        $form["transaction[wallet]"] = "";

        $client->submit($form);

        // Redirige et affiche le Flashmessage
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('#flash-validation')->count());

    }

    public function testEditTransaction() {
        // Simule un faux navigateur
        $client = static::createClient();

        // Crée mon user de test
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('marc@gmail.com');

        //Choisi une transaction de ce user
        $transactionRepository = static::getContainer()->get(TransactionRepository::class);
        $testTransaction = $transactionRepository->findOneBy(['user' => $testUser->getId()]);

        // simule l'action de login
        $client->loginUser($testUser);

        // Atteint la home page
        $client->request('GET', 'http://cryptool.localhost/transaction-'.$testTransaction->getUuid().'');
        $crawler = $client->request('GET', 'http://cryptool.localhost/transaction-'.$testTransaction->getUuid().'');

        // Récupère le lien d'une transaction et clique
        $editLink = $crawler->filter('#edit_link')->link();
        $client->click($editLink);

        $crawler = $client->request('GET', 'http://cryptool.localhost/transaction-'.$testTransaction->getUuid().'/edit');

        //Atteint la page d edition
        $this->assertSelectorTextContains('h1', 'Modifier la transaction');

        //Rempli les données du formulaire
        $form = $crawler->selectButton("Modifier")->form();
        $form["transaction[crypto]"] = 1;
        $form["transaction[quantity]"] = 5;
        $form["transaction[originalprice]"] = 3044.55;
        $form["transaction[wallet]"] = "";

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
        $transactionRepository = static::getContainer()->get(TransactionRepository::class);
        $testTransaction = $transactionRepository->findOneBy(['user' => $testUser->getId()]);

        // simule l'action de login
        $client->loginUser($testUser);

        // Atteint la page concerner
        $client->request('GET', 'http://cryptool.localhost/transaction-'.$testTransaction->getUuid().'/edit');
        $crawler = $client->request('GET', 'http://cryptool.localhost/transaction-'.$testTransaction->getUuid().'/edit');

        //Soumet le formulaire de suppression
        $form = $crawler->selectButton("btnremove-action")->form();
        $client->submit($form);

        // Redirige et affiche le Flashmessage
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('#flash-validation')->count());
    }

}