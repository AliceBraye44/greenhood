<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class TransformAdressGeo
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
      $this->client = $client;
    }

    // to transform adress to GPS coordinates with Api adress data gouv
    public function geocodeAddress($adress) {

        $response = $this->client->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/?q='.$adress
        );

        $coordinates = $response->toArray()["features"][0]["geometry"]["coordinates"];

        return $coordinates;
    }

}
