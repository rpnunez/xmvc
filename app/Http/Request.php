<?php

namespace App\Http;

class Request
{
    protected $uri;
    protected $method;
    protected $params;
    protected $body;

    public function __construct()
    {
        $this->uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = $_GET;
        $this->body = $_POST;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function method()
    {
        return $this->method;
    }

    public function input($key, $default = null)
    {
        return $this->body[$key] ?? $this->params[$key] ?? $default;
    }

    public function all()
    {
        return array_merge($this->params, $this->body);
    }
}