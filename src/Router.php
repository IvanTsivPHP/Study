<?php

namespace App;

use App\Exception\NotFoundException;

class Router
{
    public $routes = [];
    public $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function get($path, $callback, $access, $method = 'GET')
    {
        $this->routes[] = new Route($path, $callback, $access, $method);
    }

    public function dispatch()
    {
        $page = explode('?', $_SERVER['REQUEST_URI'])[0];
        foreach ($this->routes as $route) {
            if ($route->match($_SERVER['REQUEST_METHOD'], $page)) {
                return $route->run($page);
            }
        }
        throw new NotFoundException();
    }
}
