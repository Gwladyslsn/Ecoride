<?php

define("ROOTHPATH", __DIR__ . '/../'); // Pour se baser sur le chemin racine
require ROOTHPATH . '/vendor/autoload.php';

use App\Controller\Controller;

$routes = require ROOTHPATH . 'config/routes.php';
var_dump($routes);
$controller = new Controller($routes);
$controller->route();
