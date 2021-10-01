<?php

public function Test() {
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
        'sort' => 'cmc_rank',
        'limit' => '100',
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