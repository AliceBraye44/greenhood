<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CallApiService
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDataApi(): array
    {
        $response = $this->client->request(
            'GET',
            //'https://data.nantesmetropole.fr/api/records/1.0/search/?dataset='.$dataset
            'https://data.nantesmetropole.fr/api/records/1.0/search/?dataset=244400404_decheteries-ecopoints-nantes-metropole'
        );
        return $response->toArray(); 
    }

}

