<?php

use App\Controllers\Router;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/app/View');
$twig = new Environment($loader);

$router = new Router($twig);
try {
    $router->handleRequest();
} catch (LoaderError|SyntaxError|RuntimeError $e) {
}
