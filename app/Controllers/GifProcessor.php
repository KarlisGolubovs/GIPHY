<?php declare(strict_types=1);

namespace Giphy\Controllers;

use Giphy\Models\AppClient;

class GifProcessor
{
    private AppClient $client;

    public function __construct()
    {
        $this->client = new AppClient();
    }

    public function searchGif(): array
    {
        $search = $_POST['search'] ?? '';
        return $this->client->search($search);
    }

    public function getTrendingGifs(): array
    {
        return $this->client->trending();
    }
}
