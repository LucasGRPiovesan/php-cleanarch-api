<?php

namespace Frameworks\Web\Routes;

class Router
{
    protected $uri;
    protected $method;
    
    public array $payload;
    public array $queryParams = [];

    private $routes = [];

    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = $_GET;

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

    public function patch(string $path, callable $handler)
    {
        $this->addRoute('PATCH', $path, $handler);
    }

    public function delete(string $path, callable $handler)
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler)
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch()
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $this->method) {
                continue;
            }

            $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route['path']);
            $pattern = "#^{$pattern}$#";

            if (preg_match($pattern, $this->uri, $matches)) {
                array_shift($matches);

                preg_match_all('#\{([\w]+)\}#', $route['path'], $paramNames);
                $paramNames = $paramNames[1];

                $params = array_combine($paramNames, $matches);
                $this->queryParams = array_merge($this->queryParams, $params);

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