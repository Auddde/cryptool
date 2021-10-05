<?php


namespace App\Services;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionService extends AbstractController
{
    /**
     * Remplace par NULL le champs wallet pour une transaction $id
     */
    private function updateNullWalletForTransaction(Transaction $transaction) {
        $transaction->setWallet(NULL);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }

    /**
     * Remplace par null le champs wallet pour toutes les transactions ayant le wallet $wallet
     */
    public function updateNullWalletForAllTransactions(Wallet $wallet) {

        //Récupère un tableau des transactions concernées
        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy([
           "wallet" => $wallet,
        ]);

        //Update à null le champ wallet pour chaque transaction
        foreach ($transactions as $transaction) {
            $this->updateNullWalletForTransaction($transaction);
        }
    }

    /**
     * Calcule pour chaque transaction sa valeur actuelle
     */
    public function calculateValueOfDay(Transaction $transaction, array $exchange):float
    {
        return (round( ($transaction->getQuantity()) * ($exchange[$transaction->getCrypto()->getIdmarketcoin()]), 2));
    }

    /**
     * Calcule pour un user son solde du jour en prenant en compte le change
     */
    public function calculateCurrentSolde(array $transactions) :float
    {
        $total = 0;
        foreach($transactions as $transaction) {
            $total += $transaction->getDaylyvalue();
        }

        return $total;
    }

    /**
     * Calcul le gain obtenu pour une transaction
     */
    public function calculateGainTransaction(int $currentSolde, int $originalSolde) :int
    {
        return ($currentSolde - $originalSolde);
    }

    /**
     * Calcul le pourcentage de valorisation entre un solde original et un solde actuel
     */
    public function calculateValoTransaction(int $currentSolde, int $originalSolde) :string
    {
        //soit y1=première valeur et y2=deuxième valeur
        //taux = ((y2 - y1) / y1)*100
        return ((($currentSolde - $originalSolde) / $originalSolde) * 100 ) ;
    }

}