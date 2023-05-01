<?php

namespace App\Controllers;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function FastRoute\simpleDispatcher;

class Router
{
    private array $routes;
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->routes = [
            '/' => ['GiphyController', 'search'],
            '/random' => ['GiphyController', 'random'],
        ];

        $this->twig = $twig;
    }

    /**
     * @throws RuntimeError
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function handleRequest(): void
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->routes as $route => $handler) {
                $r->addRoute('GET', $route, $handler);
            }
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                header('HTTP/1.0 404 Not Found');
                echo $this->twig->render('404.twig');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header('HTTP/1.0 405 Method Not Allowed');
                echo $this->twig->render('405.twig', ['allowedMethods' => $allowedMethods]);
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                [$controllerName, $methodName] = $handler;

                $controller = new $controllerName();
                $response = $controller->$methodName();

                echo $this->twig->render('search.twig', ['gifs' => $response]);
                break;
        }
    }
}
