<?php declare(strict_types=1);

namespace Giphy\Controllers;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Giphy\Models\AppClient;
use Twig\Environment;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;
    private GifProcessor $gifProcessor;
    private Environment $twig;

    public function __construct(AppClient $appClient, Environment $twig)
    {
        $this->gifProcessor = new GifProcessor($appClient);
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->get('/', [$this, 'home']);
            $r->post('/search', [$this, 'search']);
            $r->get('/trending', [$this, 'trending']);
        });
        $this->twig = $twig;
    }

    public function handleRequest($httpMethod, $uri)
    {
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $this->show404();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->show405();
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $params = $routeInfo[2];
                call_user_func_array($handler, $params);
                break;
        }
    }

    public function home()
    {
        $template = $this->twig->load('home.twig');
        echo $template->render();
    }

    public function search()
    {
        $search = $_POST['search'] ?? '';
        $gifs = $this->gifProcessor->searchGif($search);
    }

    public function trending()
    {
        $gifs = $this->gifProcessor->getTrendingGifs();
    }

    private function show404()
    {
        header('HTTP/1.0 404 Not Found');
        echo '404 Page Not Found';
    }

    private function show405()
    {
        header('HTTP/1.0 405 Method Not Allowed');
        echo '405 Method Not Allowed';
    }
}
