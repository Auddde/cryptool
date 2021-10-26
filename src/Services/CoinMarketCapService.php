<?php


namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinMarketCapService extends AbstractController
{

    // Création du client
    private $client;

    //injection de dépandance
    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    /**
      * Récupère la liste de toutes les cryptos, utile pour ma BDD crypto etc :
      */
    private function bddCryptoContent() {
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

    /**
     * Récupère les infos toutes les cryptos,  utile pour ma BDD crypto_info etc :
     */
    private function bddCryptoInfoContent() {

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


    /**
     * Convertit une transaction en sa valeur actuelle selon le cours
     */
    public function cryptoPriceConversionToday($quantity, $idmarketcoin) {

        //Endpoint avec paramètres
        $url = 'https://pro-api.coinmarketcap.com/v1/tools/price-conversion';
        $parameters = [
            'amount' => $quantity,
            'id' => $idmarketcoin,
            'convert' => 'EUR'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters :  Génère une chaîne de requête en encodage UR
        $url_parameters = "{$url}?{$qs}"; // create the request URL

        //Headers
        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 4f8dd73c-46d3-477b-8140-455afd791fc8' //Ma propre clé disponnible sur https://pro.coinmarketcap.com/account
        ];

        //Envoie ma requete en GET
        $response = $this->client->request(
            'GET',
            ''.$url_parameters.'',
            [
                'headers' => $headers,
            ]
        );

        //Transforme la réponse récupérée en tableau
        $responseInarray = $response->toArray();

        //Ne récupère que le change
        return $responseInarray['data']['quote']['EUR']['price'];

    }



}