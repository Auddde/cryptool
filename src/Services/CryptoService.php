<?php


namespace App\Services;

use App\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CryptoService extends AbstractController
{

    /**
     * Génère un tableau de change pour les monnaies utilisée, toutes transations tout user confondu
     * pour 1 item de cette crypto : 1 requête API au lieu de 'nombre_de_transactions'
     */

    public function generateExchange(CoinMarketCapService $coinMarketCapService): array
    {
        //liste toutes mes crypto
        $allCrypto = $this->getDoctrine()->getRepository(Transaction::class)->listAllCryptoUsers();

        //Gènère un tableau de change par crypto utilisée par les transaction d'un user, pour 1 de chaque crypto
        foreach ($allCrypto as $crypto) {
            $exchange[$crypto['idmarketcoin']] = $coinMarketCapService->cryptoPriceConversionToday(1, $crypto['idmarketcoin']);
        }
        return $exchange;
    }

}