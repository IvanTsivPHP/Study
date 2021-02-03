<?php

namespace App;

use App\Exception\AccessDeniedException;

class Route
{
    private $method;
    private $path;
    private $callback;
    private $access;

    public function __construct($path, $callback, $access, $method)
    {
        $this->path = $this->preparePath($path);
        $this->callback = $callback;
        $this->method = $method;
        $this->access = $access;
    }

    private function prepareCallback($callback)
    {
        if (is_callable($callback)) {
            return $callback;
        } else {
            $route = explode('@', $callback);
            $class = $route[0];
            $method = $route[1];

            return [new $class, $method];
        }
    }

    private function preparePath($path)
    {
        if (substr($path, 0, 1) != '/') {
            $path = '/' . $path;
        }
        if ((strlen($path) != 1) && (substr($path, -1) == '/')) {
            $path = substr($path, 0 ,-1);
        }

        return $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function match($method, $uri):bool
    {
        if (($method == $this->method) &&
            (preg_match('/^' . str_replace(['*', '/'], ['\w+', '\/'], $this->getPath()) . '$/', $uri))) {
            return true;
        }

        return false;
    }

    private function Access()
    {
        if ($_SESSION['access'] == 0 && $this->access > 0) {
            header('Location: /signin');
        } elseif ($this->access > $_SESSION['access']) {
            throw new AccessDeniedException();
        }
    }

    public function run($uri)
    {
        $this->Access();
        $uriArray = explode('/', $uri);
        $pathArray = explode('/', $this->getPath());
        $paramArray = array_diff_assoc($uriArray, $pathArray);
        $preparedCallback = $this->prepareCallback($this->callback);

        return $preparedCallback($paramArray);
    }
}
