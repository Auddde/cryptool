<?php

namespace App\Controller;

use App\Entity\Transaction;

use App\Services\CoinMarketCapService;
use App\Services\TransactionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends AbstractController
{

    /**
     * Affiche la home page, une fois l'utilisateur connecté
     * @Route("/")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function index(CoinMarketCapService $coinMarketCapService, TransactionService $transactionService): Response
    {
        $user = $this->getUser();

        //Génère les transactions de mon user
        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy(
            ['user' => $user->getId()]
        );


        // Génère mon tableau de change pour les crypto dont on a besoin, si j'ai des transactions
        if(!empty($transactions)) {
            $exchange = $this->generateExchange($coinMarketCapService);

            //Calcule la valeur du jour et la met à jour pour chaque transaction
            $this->updateValueOfDay($transactions, $transactionService, $exchange);

            // Calcul le solde initial pour toutes les transactions confondues du User VS solde du jour selon le change
            $soldeInitial = $this->getDoctrine()->getRepository(Transaction::class)->soldeUser($user->getId());
            $soldeCurrent = $transactionService->calculateCurrentSolde($transactions);

        } else {
            $soldeInitial = 0;
            $soldeCurrent = 0;
        }

        return $this->render('front/index.html.twig', [
            'transactions' => $transactions,
            'soldeInitial' => $soldeInitial,
            'soldeCurrent' => $soldeCurrent,
        ]);
    }

    /**
     * Génère un tableau de change pour les monnaies
     * pour 1 item de cette crypto : 1 requête API au lieu de 'nombre_de_transactions'
     */
    private function generateExchange(CoinMarketCapService $coinMarketCapService): array
    {
        //liste toutes mes crypto
        $allCrypto = $this->getDoctrine()->getRepository(Transaction::class)->listAllCryptoUser($this->getUser());

        //Gènère un tableau de change par crypto utilisée par les transaction d'un user, pour 1 de chaque crypto
        foreach ($allCrypto as $crypto) {
            $exchange[$crypto['idmarketcoin']] = $coinMarketCapService->cryptoPriceConversionToday(1, $crypto['idmarketcoin']);  //ex : idMarket1Conv = 234;
        }
        return $exchange;
    }

    /**
     * Calcule la valeur du jour et l'ajoute pour chaque transaction via son setter
     */
    private function updateValueOfDay(array $transactions, TransactionService $transactionService, $exchange): void
    {
        foreach ($transactions as $transaction) {
            $newvalue = $transactionService->calculateValueOfDay($transaction, $exchange);
            $transaction->setDaylyvalue($newvalue);
        }
    }

}


