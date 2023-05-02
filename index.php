<?php declare(strict_types=1);

use Giphy\Controllers\Router;
use Giphy\Models\AppClient;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/views');
$twig = new Environment($loader);

$router = new Router(new AppClient(), $twig);

$router->handleRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
