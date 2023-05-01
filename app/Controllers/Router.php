<?php

namespace App\Controllers;

use App\Models\GifPropperties;
use App\Models\GiphyRequest;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Router
{
    private Environment $twig;
    private GiphyRequest $giphyRequest;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->giphyRequest = new GiphyRequest();
    }

    public function handleRequest(): void
    {
        $query = $_GET['query'] ?? '';

        if (!empty($query)) {
            $gifsData = $this->giphyRequest->search($query);
            $gifs = array_map(function ($gifData) {
                return new GifPropperties($gifData['images']['original']['url']);
            }, $gifsData);
        } else {
            $gifs = [];
        }

        try {
            echo $this->twig->render('gif_search_results.twig', ['gifs' => $gifs]);
        } catch (LoaderError|SyntaxError|RuntimeError $e) {
        }
    }
}
