<?php declare(strict_types=1);

namespace Giphy\Controllers;

use Giphy\Models\AppClient;
use Giphy\Models\GIF;
use GuzzleHttp\Exception\GuzzleException;

class GifProcessor
{
    private AppClient $client;
    private AppClient $appClient;

    public function __construct(AppClient $appClient)
    {
        $this->client = new AppClient();
        $this->appClient = $appClient;
    }

    public function searchGif(string $query, int $limit = 10): array
    {
        $response = $this->appClient->search($query, $limit);
        $data = $response['data'] ?? [];
        $gifs = [];
        foreach ($data as $gif) {
            $gifs[] = new GIF($gif['images']['original']['url']);
        }
        return $gifs;
    }


    /**
     * @throws GuzzleException
     */
    public function getTrendingGifs(): array
    {
        return $this->client->trending();
    }
}
