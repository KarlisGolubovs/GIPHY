<?php declare(strict_types=1);

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GiphyRequest
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.giphy.com/v1/',
        ]);
        $this->apiKey = $_ENV['API_KEY'] ?? '';
    }

    public function search(string $query, int $limit = 25, int $offset = 0): array
    {
        $response = $this->client->request('GET', 'gifs/search', [
            'query' => [
                'q' => $query,
                'api_key' => $this->apiKey,
                'limit' => $limit,
                'offset' => $offset,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }

    /**
     * @throws GuzzleException
     */
    public function random(string $query = ''): array
    {
        $response = $this->client->request('GET', 'gifs/random', [
            'query' => [
                'api_key' => $this->apiKey,
                'tag' => $query,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }
}