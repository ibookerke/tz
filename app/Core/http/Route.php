<?php

namespace Core\http;

class Route
{

    public string $requestType;
    public string $controller;
    public string $method;

    public function __construct(array $data)
    {
        $this->requestType = $data['type'];
        $this->controller = $data['route'][0];
        $this->method = $data['route'][1];
    }
}