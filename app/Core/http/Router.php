<?php

namespace Core\http;

/**
 * The Router class handles routing in the application.
 */
class Router
{
    /**
     * The URL being handled by the router.
     *
     * @var string
     */
    protected string $url;

    /**
     * The current route being processed by the router.
     *
     * @var Route
     */
    protected Route $route;

    /**
     * The collection of defined routes in the application.
     *
     * @var array
     */
    protected array $routes = [];

    /**
     * Handle the incoming request and process the route.
     *
     * @throws \Exception If an error occurs while handling the route.
     */
    public function handle(): void
    {
        try {
            $parsedUrl = $this->parseUrl();
            $this->url = $parsedUrl['path'];

            $this->routes = require_once "../routes/web.php";

            if (!array_key_exists($this->url, $this->routes)) {
                throw new \Exception('Route not Found', 404);
            }

            $this->route = $this->routes[$this->url];

            $this->launchController();
        } catch (\Exception $ex) {
            throw new \Exception("Error happened while trying to handle route: {$ex->getMessage()}", 404);
        }
    }

    /**
     * Parse the current URL.
     *
     * @return array|null The parsed URL components.
     *
     * @throws \Exception If an error occurs while parsing the URL.
     */
    public function parseUrl(): ?array
    {
        try {
            $escaped_url = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
            $url = filter_var(trim($escaped_url, '/'));

            return parse_url($url);
        } catch (\Exception $ex) {
            throw new \Exception("Error happened while trying to parse url: " . $ex->getMessage());
        }
    }

    /**
     * Launch the appropriate controller and execute the assigned method.
     *
     * @throws \Exception If the controller or method assigned to a route is not found.
     */
    protected function launchController(): void
    {
        try {
            $path = '../app/' . str_replace("\\", '/', $this->route->controller . '.php');
            if (!file_exists($path)) {
                throw new \Exception("Controller assigned to a route not found");
            }

            require_once $path;
            $controller = new $this->route->controller();

            if (!method_exists($controller, $this->route->method)) {
                throw new \Exception("Method assigned to a route controller not found");
            }
            $controller->{$this->route->method}();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
