<?php declare(strict_types=1);

namespace Giphy\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AppClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function search(string $query): array
    {
        $url = 'https://api.giphy.com/v1/gifs/search';
        $res = $this->client->request('GET', $url, [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'q' => $query,
                'limit' => 15,
                'rating' => 'g',
            ],
        ]);
        $gifs = json_decode($res->getBody()->getContents())->data;
        return $gifs;
    }

    /**
     * @throws GuzzleException
     */
    public function random(string $tag = null): array
    {
        $url = 'https://api.giphy.com/v1/gifs/random';
        $query = [
            'api_key' => $_ENV['API_KEY'],
            'rating' => 'g',
        ];
        if ($tag !== null) {
            $query['tag'] = $tag;
        }
        $res = $this->client->request('GET', $url, [
            'query' => $query,
        ]);
        $gif = json_decode($res->getBody()->getContents())->data;
        return $gif;
    }

    /**
     * @throws GuzzleException
     */
    public function trending(): array
    {
        $url = 'https://api.giphy.com/v1/gifs/trending';
        $res = $this->client->request('GET', $url, [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'limit' => 15,
                'rating' => 'g',
            ],
        ]);
        $gifs = json_decode($res->getBody()->getContents())->data;
        return $gifs;
    }
}
