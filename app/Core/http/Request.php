<?php

namespace Core\http;

use Services\SecurityService;

/**
 * The Request class represents an HTTP request.
 */
class Request
{
    /**
     * The request data.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Request constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        // TODO: Refactor
        $this->data = $this->getRequestBody();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!SecurityService::CSRFValid($this->get('_token'))) {
                throw new \Exception("CSRF Error");
            }
        }
    }

    /**
     * Get the value of a request parameter by key.
     *
     * @param string $key The parameter key.
     *
     * @return mixed|null The parameter value if found, or null otherwise.
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Get all the request parameters.
     *
     * @return array The request parameters.
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Get the request body as an array of parameters.
     *
     * @return array The request body parameters.
     */
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
