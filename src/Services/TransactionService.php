<?php


namespace App\Services;

use App\Entity\Transaction;
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

}