<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function addRoute(string $path, string $controller, string $method): void
    {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch(string $uri): void
    {
        $path = strtok($uri, '?');

        if (array_key_exists($path, $this->routes)) {
            $route = $this->routes[$path];
            $controllerName = $route['controller'];
            $methodName = $route['method'];

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                } else {
                    // Handle method not found
                    header("HTTP/1.0 404 Not Found");
                    echo "Error: Method '{$methodName}' not found in controller '{$controllerName}'.";
                }
            } else {
                // Handle controller not found
                header("HTTP/1.0 404 Not Found");
                echo "Error: Controller '{$controllerName}' not found.";
            }
        } else {
            // Handle route not found
            header("HTTP/1.0 404 Not Found");
            echo "Error: Route '{$path}' not found.";
        }
    }
}
