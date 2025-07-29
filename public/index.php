<?php
session_start();

define("ROOTPATH", __DIR__ . '/../'); // Pour se baser sur le chemin racine
require ROOTPATH . '/vendor/autoload.php';



use App\Core\Router;

$router = new Router();

// Load routes from config/routes.php
$routes = require ROOTPATH . 'config/routes.php';

foreach ($routes as $path => $routeInfo) {
    $router->addRoute($path, $routeInfo['controller'], $routeInfo['method']);
}

$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/index.php', '', $uri); // Corrige l’URI
$router->dispatch($uri);
