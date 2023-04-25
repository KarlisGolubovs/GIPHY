<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ApiClientRequest;
use App\GifProcessor;

if (isset($_GET['searchTerm'])) {
    $apiClient = new ApiClientRequest();
    $data = $apiClient->fetchData();

    $gifProcessor = new GifProcessor();
    $html = $gifProcessor->processGifs($data);

    echo $html;
} else {
    include_once('index.html');
}
