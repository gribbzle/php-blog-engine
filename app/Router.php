<?php

declare(strict_types=1);

namespace App;

class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $callback): void
    {
        $this->routes['GET'][$pattern] = $callback;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $pattern => $callback) {
            $regex = $this->buildRegex($pattern);

            if (preg_match($regex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($callback, $params);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function buildRegex(string $pattern): string
    {
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $pattern . '$#';
    }
}
