<?php

require_once 'vendor/autoload.php';

use App\getApiClient;

$searchTerm = $_GET['searchTerm'] ?? '';
$giphy = new getApiClient;
$apiKey = getenv('API_KEY');
$gifs = $giphy->fetchData($apiKey, $searchTerm);
$html = $giphy->processGifs($gifs);