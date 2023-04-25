<?php declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiClientRequest
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function fetchData() : array
    {
        $url = "https://api.giphy.com/v1/gifs/search?api_key=" . getenv('API_KEY') . "&q=&limit=25&offset=0&rating=g&lang=en";
        try {
            $res = $this->client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            return json_decode($res->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return [];
        }
    }
}
