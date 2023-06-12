<?php

namespace Core;

use Core\http\Router;

/**
 * The Application class represents the core application and handles the execution flow.
 */
class Application
{
    /**
     * The router instance for handling HTTP requests.
     *
     * @var Router
     */
    public Router $router;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Runs the application by handling HTTP requests.
     *
     * @return void
     */
    public function run(): void
    {
        try {
            $this->router->handle();
        } catch (\Exception $ex) {
            abort(
                500,
                null,
                $ex->getMessage() . ' in ' . $ex->getFile() . ' on ' . $ex->getLine()
            );
        }
    }
}
