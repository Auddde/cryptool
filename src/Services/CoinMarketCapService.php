<?php


namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CoinMarketCapService extends AbstractController
{
    /**
     * Script me permettant de récupérer des information via l'API CoinMarketCap
     * Pour l'insertion en BDD d'information statique sur les crypto
     * Tables : crypto et crypto_info
     * => ajouter une route pour récupérer le contenu
     */
    public function scriptMap() {
        $map = $this->bddCryptoContent();
        return new Response('<body>'.$map.'</body>') ;
    }

    public function bddCryptoContent() {
        /**
         * Récupère la liste une carte de toute les cryptos, utile pour ma BDD crypto etc :
         *
        "id": 1,
        "rank": 1,
        "name": "Bitcoin",
        "symbol": "BTC",
        "slug": "bitcoin",
        "is_active": 1,
        "first_historical_data": "2013-04-28T18:47:21.000Z",
        "last_historical_data": "2020-05-05T20:44:01.000Z",
        "platform": null
         */

        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/map';
        $parameters = [
            'start' => '1',
            'limit' => '100',
            'sort' => 'cmc_rank'
            //'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 4f8dd73c-46d3-477b-8140-455afd791fc8' //Ma propre clé disponnible sur https://pro.coinmarketcap.com/account
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        return $response;
    }

    public function bddCryptoInfoContent() {
        /**
         * Récupère la liste une carte de toute les cryptos, pour les meta
         */

        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info';
        $parameters = [
            'id' => '1,1027,2010,825,1839,52,5426,3408,6636,74,7083,4172,5805,4687,1975,2,4030,1831,3717,3794,3890,8916,2280,512,3077,4943,1958,4195,1321,2011,2416,4642,6783,4023,10791,328,7186,3635,6892,1765,7278,3155,1720,6535,3513,6719,5994,5034,1376,4256',
            //'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 4f8dd73c-46d3-477b-8140-455afd791fc8' //Ma propre clé disponnible sur https://pro.coinmarketcap.com/account
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        return $response;
    }

}