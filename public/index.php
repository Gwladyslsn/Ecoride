<?php
// 1. Sécurisation du cookie de session
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $secure,   // ⚠️ Active sur HTTPS
    'httponly' => true,    // Empêche JS de lire le cookie
    'samesite' => 'Lax',   // ou 'Strict' si pas besoin de cross-site login
]);

session_start();

// 2. Reste de ton code inchangé
define("ROOTPATH", __DIR__ . '/../');
require ROOTPATH . '/vendor/autoload.php';

use App\Core\Router;

$router = new Router();
$routes = require ROOTPATH . 'config/routes.php';

foreach ($routes as $path => $routeInfo) {
    $router->addRoute($path, $routeInfo['controller'], $routeInfo['method']);
}

$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/index.php', '', $uri);
$router->dispatch($uri);




