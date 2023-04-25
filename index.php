<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ApiClientRequest;
use App\GifProcessor;

$apiClient = new ApiClientRequest();
$data = $apiClient->fetchData();

$gifProcessor = new GifProcessor();
$html = $gifProcessor->processGifs($data);

echo $html;
