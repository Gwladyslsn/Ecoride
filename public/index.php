<?php

define("ROOTPATH", __DIR__ . '/../'); // Pour se baser sur le chemin racine
require ROOTPATH . '/vendor/autoload.php';

use App\Controller\Controller;

$routes = require ROOTPATH . 'config/routes.php';
$controller = new Controller($routes);
$controller->route();
