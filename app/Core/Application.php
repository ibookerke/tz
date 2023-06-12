<?php

namespace Core;
use Core\http\Router;

class Application
{
    public Router $router;
    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        try {
            $this->router->handle();
        }
        catch (\Exception $ex) {
            abort(
                500,
                null,
                $ex->getMessage() . ' in ' . $ex->getFile() . ' on ' . $ex->getLine()
            );
        }

    }

}