<?php

namespace App\Controller;

use App\Entity\Transaction;

use App\Entity\User;
use App\Entity\Valorisation;
use App\Services\CoinMarketCapService;
use App\Services\CryptoService;
use App\Services\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CronController extends AbstractController
{
    /**
     * Save soldes
     * @Route("/tui4445")
     */
    public function cron(transactionService $transactionService, CryptoService $cryptoService, CoinMarketCapService $coinMarketCapService): Response
    {

        // Récupère tous les users
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        // Génère le tableau de change
        $exchange = $cryptoService->generateExchange($coinMarketCapService);

        foreach ($users as $user) {

            //Récupère les transactions du user
            $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy([
                'user' => $user->getId()
            ]);

            //Calcule la valeur du jour et la met à jour pour chaque transaction
            $transactionService->updateValueOfDay($transactions, $transactionService, $exchange);

            $soldeInitial = $this->getDoctrine()->getRepository(Transaction::class)->soldeUser($user->getId());
            $soldeCurrent = $transactionService->calculateCurrentSolde($transactions);

            $date = new \DateTime();

            //Creation de la valorisation
            $valorisation = new Valorisation();
            $valorisation->setDate($date);
            $valorisation->setSoldeinitial($soldeInitial);
            $valorisation->setSoldeofday($soldeCurrent);
            $valorisation->setUser($user);

            // Supression de l'entrée la plus vieille si plus de 7 entrées
            $existingValorisations = $this->getDoctrine()->getRepository(Valorisation::class)->findBy([
                'user' => $user->getId(),
            ]);

            if (count($existingValorisations) > 6) {
                //efface la plus vieille si plus de 7 entrées
                $this->getDoctrine()->getRepository(Valorisation::class)->removeValorisation($existingValorisations[0]);
            }

            //Insertion
            //$this->getDoctrine()->getRepository(Valorisation::class)->insertValorisation($valorisation);
            $em = $this->getDoctrine()->getManager();
            $em->persist($valorisation);
            $em->flush();
        }

        return $this->render('front/soon.html.twig');
    }

}


