<?php

require_once 'vendor/autoload.php';

use App\GiphyApp;

$searchTerm = $_GET['searchTerm'] ?? '';
$giphy = new GiphyApp();
$apiKey = getenv('API_KEY');
$gifs = $giphy->fetchData($apiKey, $searchTerm);
$html = $giphy->processGifs($gifs);