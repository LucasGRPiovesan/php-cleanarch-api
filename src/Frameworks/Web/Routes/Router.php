<?php

namespace Frameworks\Web\Routes;

class Router
{
    protected $uri;
    protected $method;
    
    public array $payload;

    private $routes = [];

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method === 'POST' || $this->method === 'PATCH' || $this->method === 'PUT') {
            $this->payload = json_decode(file_get_contents('php://input'), true);
        }
    }

    public function get(string $path, callable $handler)
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler)
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch()
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $this->method && $route['path'] === $this->uri) {
                return call_user_func($route['handler'], $this);
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    public function send($statusCode, $data): void
    {
        http_response_code($statusCode);
        echo json_encode($data);
    }
}