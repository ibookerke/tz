<?php

namespace Core;
class Application
{
    protected string $url;
    public function __construct()
    {

//        try {
//            //DB connection
//
//            //handle route
//            $this->handle();
//        }
//        catch (\Exception $exception) {
//            var_dump($exception->getMessage());
//        }

    }

    public function run(): void
    {
        try {
            $parsedUrl = $this->parseUrl();
            $this->url = $parsedUrl['path'];

            $routes = require_once "../routes/web.php";
            
            if(array_key_exists($this->url, $routes)) {
                $this->handleRoute($routes[$this->url]);
            }
            else{
                abort(404);
            }
        }
        catch (\Exception $ex) {
            abort(
                500,
                '',
                $ex->getMessage() . ' in ' . $ex->getFile() . ' on ' . $ex->getLine()
            );
        }
    }

    protected function handleRoute(Route $route)
    {
        try {
//            if($_SERVER['REQUEST_METHOD'] != $route->requestType) {
//                throw new \Exception($_SERVER['REQUEST_METHOD'] . " request type not supported for this route");
//            }

            $path =  '../app/' . str_replace("\\", '/', $route->controller . '.php');
            if(!file_exists($path)) {
                throw new \Exception("Controller assigned to a route not found");
            }

            require_once $path;

            $controller = new $route->controller();

            if(!method_exists($controller, $route->method)) {
                throw new \Exception("Method assigned to a route controller not found");
            }

            $controller->{$route->method}();

        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    protected function parseUrl(): bool|int|array|string|null
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


}