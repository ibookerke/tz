<?php

namespace Core\http;

class Router
{

    protected string $url;
    protected Route $route;
    protected array $routes = [];

    public function handle(): void
    {
        try {
            $parsedUrl = $this->parseUrl();
            $this->url = $parsedUrl['path'];

            $this->routes = require_once "../routes/web.php";

            if(!array_key_exists($this->url, $this->routes)) {
                throw new \Exception('Route not Found',404);
            }

            $this->route = $this->routes[$this->url];

            $this->launchController();

        }
        catch (\Exception $ex) {
            throw new \Exception("Error happened while trying to handle route: {$ex->getMessage()}", 404);
        }
    }

    public function parseUrl(): bool|int|array|string|null
    {
        try{
            $escaped_url = htmlspecialchars( $_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
            $url = filter_var(trim($escaped_url, '/'));

            return parse_url($url);
        }
        catch (\Exception $ex) {
            throw new \Exception("Error happened while trying to parse url: " . $ex->getMessage());
        }

    }

    protected function launchController(): void
    {
        try {
            $path =  '../app/' . str_replace("\\", '/', $this->route->controller . '.php');
            if(!file_exists($path)) {
                throw new \Exception("Controller assigned to a route not found");
            }

            require_once $path;
            $controller = new $this->route->controller();

            if(!method_exists($controller, $this->route->method)) {
                throw new \Exception("Method assigned to a route controller not found");
            }
            $controller->{$this->route->method}();

        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

}