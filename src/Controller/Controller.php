<?php
namespace App\Controller;

class Controller
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function route(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routes[$uri])) {
            http_response_code(404);
            echo "Page non trouvée";
            exit;
        }

        $route = $this->routes[$uri];
        $controllerClass = $route['controller'];
        $method = $route['method'];

        try {
            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller $controllerClass introuvable");
            }

            $controller = new $controllerClass($this->routes);

            if (!method_exists($controller, $method)) {
                throw new \Exception("Méthode $method introuvable dans $controllerClass");
            }

            $controller->$method();

        } catch (\Exception $e) {
            $this->render('Templates/errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function render(string $path, array $params = []): void
    {
        $filePath = ROOTPATH . 'src/' . $path . '.php';

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("Fichier non trouvé : " . $filePath);
            }
            extract($params);
            require_once $filePath;
        } catch (\Exception $e) {
            echo "<h1>Erreur de rendu</h1>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            exit;
        }
    }
}
