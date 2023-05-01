<?php

use App\Controllers\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Error\{LoaderError, RuntimeError, SyntaxError};

require __DIR__ . '/vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/app/View');
$twig = new Environment($loader);

$router = new Router($twig);
try {
    $router->handleRequest();
} catch (LoaderError|SyntaxError|RuntimeError $e) {
}
