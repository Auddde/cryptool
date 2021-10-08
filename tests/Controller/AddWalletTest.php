<?php

/**
 * Je laisse tomber PAnther car je n'arrive pas à fixer les issues


namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;


class AddWalletTest extends PantherTestCase
{
    public function testaddWallet()
    {
        $client = static::createPantherClient(); //Pour simuler un navigateur
        $crawler = $client->request("GET", "/");  // Création d'un objet Crawler issu d’une requête GET pointant sur la home page

        //Simule la connexion de l'utilisateur

        $formLogin= $crawler->selectButton("aude")->form([
            "user[email]" => "marc@gmail.com",
            "user[password]" => "motdepasse1",
        ]);
        $client->submit($formLogin);

    }

} */