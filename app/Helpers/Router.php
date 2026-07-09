<?php

class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if ($uri === '') $uri = '/';

        foreach ($this->routes[$method] ?? [] as $pattern => $action) {
            $regex = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $pattern);
            $regex = '#^' . $regex . '$#u';

            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches);
                [$controllerName, $methodName] = $action;
                $controller = new $controllerName();
                call_user_func_array([$controller, $methodName], $matches);
                return;
            }
        }

        http_response_code(404);
        echo '404 - الصفحة غير موجودة';
    }
}
