<?php

declare(strict_types=1);

namespace Giphy\Core;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    private Controller $controller;

    public function __construct()
    {
        $this->controller = new Controller();
    }

    public function dispatch(): void
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->get('/', ['Giphy\Core\Controller', 'trending']);
            $r->get('/random', ['Giphy\Core\Controller', 'random']);
            $r->get('/search', ['Giphy\Core\Controller', 'search']);
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                $this->controller->notFound();
                break;
            case Dispatcher::FOUND:
                [$class, $method] = $routeInfo[1];
                $vars = $routeInfo[2];
                echo (new $class)->$method(...$vars);
                break;
        }
    }
}