<?php

return [
    '/' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'home'
    ],
    '/register' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'register'
    ],
    '/contact' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'contact'
    ],
    '/about' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'about'
    ],
    '/mentions' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'mentions'
    ],
    '/dashboardUser' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'dashboardUser'
    ],
    '/logout' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'logout'
    ],
    '/history' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'history'
    ],
    '/updateUser' => [
        'controller' => App\Controller\UserController::class,
        'method' => 'updateUser'
    ],
    '/updateAvatar' => [
        'controller' => App\Controller\UserController::class,
        'method' => 'updateAvatar'
    ],
    '/updateCar' => [
        'controller' => App\Controller\UserController::class,
        'method' => 'updateCar'
    ],
    '/updateImgCar' => [
        'controller' => App\Controller\UserController::class,
        'method' => 'updateImgCar'
    ],
    '/addCarpooling' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'addCarpooling'
    ],
    '/newCarpooling' => [
        'controller' => App\Controller\CarpoolingController::class,
        'method' => 'newCarpooling'
    ],
    '/Carpoolings' => [
        'controller' => App\Controller\CarpoolingController::class,
        'method' => 'showTrips'
    ],
    '/searchTripAPI' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'searchTripAPI'
    ],
    '/contactUser' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'contactUser'
    ],
    '/reviewEcoride' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'reviewEcoride'
    ],
    '/addReviewEcoride' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'addReviewEcoride'
    ],
    '/createAdmin' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'createAdmin'
    ],
    '/homeAdmin' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'homeAdmin'
    ],
    '/dashboardAdmin' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'dashboardAdmin'
    ]
];