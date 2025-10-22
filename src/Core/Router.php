<?php

namespace App\Core;

use App\Database\Database;
use App\Security\CsrfManager;
use App\Repository\UserRepository;

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

        if (!array_key_exists($path, $this->routes)) {
            header(HTTP_404);
            echo "Error: Route '{$path}' not found.";
            return;
        }

        $route = $this->routes[$path];
        $controllerName = $route['controller'];
        $methodName = $route['method'];

        if (!class_exists($controllerName)) {
            header(HTTP_404);
            echo "Error: Controller '{$controllerName}' not found.";
            return;
        }

        // 🧩 Prépare les dépendances pour les contrôleurs qui en ont besoin
        switch ($controllerName) {
            case 'App\Controller\AuthController':
                $pdo = Database::getConnection();
                $csrfManager = new CsrfManager();
                $userRepository = new UserRepository($pdo);
                $controller = new $controllerName($userRepository, $csrfManager);
                break;

            default:
                $controller = new $controllerName();
        }

        if (!method_exists($controller, $methodName)) {
            header(HTTP_404);
            echo "Error: Method '{$methodName}' not found in controller '{$controllerName}'.";
            return;
        }

        // ✅ Gestion POST pour handleForm
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $methodName === 'handleForm') {
            $controller->$methodName($_POST); // passe le POST à la méthode
        } else {
            $controller->$methodName(); // GET ou autres méthodes
        }
    }
}


