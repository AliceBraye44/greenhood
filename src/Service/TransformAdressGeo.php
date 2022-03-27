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
    // TODO: make the adress dynamics with a parameter and a post method
    function geocodeAddress() {

        $response = $this->client->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/?q=8+bd+du+port'
        );

        $coordinates = $response->toArray()["features"][0]["geometry"]["coordinates"];

        return $coordinates;
    }

}
{{ }}