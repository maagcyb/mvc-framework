<?php

declare(strict_types=1);

namespace Core;

class Router
{
    protected array $routes = [];
    protected array $params = [];

    public function add(string $route, array $params = []): void
    {
        //von normaler route (string) in eine named regex umwandeln (erstellt automatisch named $matches von route)
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z]+)', $route);

        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        //start und ende von regex-string setzen und case insensitive machen
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function match(string $url): bool
    {

        $url = strtolower($url);
        $url = trim($url);

        // route ist ein regex und wurde in $router->add() von einer route in ein regex umgeschrieben
        foreach ($this->getRoutes() as $route => $params) {
            if (preg_match($route, $url, $matches)){
                foreach ($matches as $key => $match) {
                    if (is_string($key))
                        $params[$key] = $match;
                }
                $this->setParams($params);
                return true;
            }
        }
        return false;
    }

    public function dispatch(string $url): void
    {

        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)){

            $controller = $this->getParams()['controller'];
            $controller = $this->convertStringToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)){
                $controllerObject = new $controller($this->getParams());
                if (array_key_exists('action', $this->getParams())){
                    $action = $this->getParams()['action'];
                } else {
                    $action = 'index';
                }

                $action = $this->convertStringToCamelCase($action);
                if (!preg_match('/action$/i', $action)){
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Action $action not found", 404);
                }
            } else {
                throw new \Exception("Controller $controller not found", 404);
            }
        } else {
            throw new \Exception('ERROR 404: Not Found', 404);
        }
    }

    public function removeQueryStringVariables(string $url): string
    {
        if ($url != ''){
            //separiert den normalen URL von dem QueryString (ab ?)
            //posts/index?sali=mueter&John=Doe
            //wird zu einer array [0 => /posts/index, 1 => [sali => mueter]
            $queryParams = explode('?', $url, 2);
            if (!str_contains($queryParams[0], '=')){
                $url = $queryParams[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    protected function getNamespace(): string
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->getParams())){
            $namespace .= $this->getParams()['namespace'] . '\\';
        }


        return $namespace;
    }

    public function convertStringToStudlyCaps(string $string): string
    {
        $string = trim($string);
        return ucfirst($string);
    }

    public function convertStringToCamelCase(string $string): string
    {
        return lcfirst($this->convertStringToStudlyCaps($string));
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
    /**
     * @param array $routes
     */
}