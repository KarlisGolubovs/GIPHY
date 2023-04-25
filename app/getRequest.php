<?php declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class getApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function fetchData(string $apiKey, string $searchTerm) : array
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
    public function processGifs(array $gifs) : string
    {
        $html = '';
        foreach ($gifs['data'] as $gif) {
            $html .= '<img src="' . $gif['images']['original']['url'] . '" alt="' . $gif['title'] . '">';
        }
        return $html;
    }
}
