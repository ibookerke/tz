<?php

namespace Core\http;

/**
 * The Route class represents a route in the application.
 */
class Route
{
    /**
     * The request type associated with the route.
     *
     * @var string
     */
    public string $requestType;

    /**
     * The controller associated with the route.
     *
     * @var string
     */
    public string $controller;

    /**
     * The method associated with the route.
     *
     * @var string
     */
    public string $method;

    /**
     * Route constructor.
     *
     * @param array $data The route data.
     */
    public function __construct(array $data)
    {
        $this->requestType = $data['type'];
        $this->controller = $data['route'][0];
        $this->method = $data['route'][1];
    }
}
