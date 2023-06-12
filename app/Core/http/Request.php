<?php

namespace Core\http;

use Services\SecurityService;

class Request
{
    protected array $data = [];

    public function __construct()
    {
        //TODO: Refactor
        $this->data = $this->getRequestBody();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!SecurityService::CSRFValid($this->get('_token'))) {
                throw new \Exception("CSRF Error");
            }
        }
    }
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function all(): array
    {
        return $this->data;
    }

    protected function getRequestBody(): array
    {

        $pairs = explode("&", file_get_contents("php://input"));
        $vars = array();

        foreach ($pairs as $pair) {
            $nv = explode("=", $pair);
            $name = urldecode($nv[0]);
            $value = urldecode($nv[1] ?? null);
            $vars[$name] = SecurityService::getEscapedString($value);
        }
        return $vars;
    }

}