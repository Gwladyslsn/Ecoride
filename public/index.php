<?php
require_once __DIR__ . '/../config/config.php';

// Détermination du cookie sécurisé
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
if (ENV === 'prod') {
    $secure = true;
}

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

require_once ROOTPATH . '/vendor/autoload.php';

use App\Core\Router;

$router = new Router();
$routes = require_once ROOTPATH . 'config/routes.php';

foreach ($routes as $path => $routeInfo) {
    $router->addRoute($path, $routeInfo['controller'], $routeInfo['method']);
}

$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/index.php', '', $uri);
$router->dispatch($uri);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



