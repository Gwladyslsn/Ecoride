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
    'controller' => App\Controller\UserController::class,
    'method' => 'showDashboardUser'
],
    '/logout' => [
        'controller' => App\Controller\PageController::class,
        'method' => 'logout'
    ],
    '/history' => [
        'controller' => App\Controller\UserController::class,
        'method' => 'showHistoryUser'
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
    '/updatePreferences' => [
        'controller' => App\Controller\UserController::class,
        'method' => 'updatePreferences'
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
    '/tripDetails' => [
    'controller' => App\Controller\CarpoolingController::class,
    'method' => 'showTripDetails'
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
    ],
    '/bookTrip' => [
        'controller' => App\Controller\BookingController::class,
        'method' => 'bookTrip'
    ],
    '/cancelBooking' => [
        'controller' => App\Controller\BookingController::class,
        'method' => 'deleteBooking'
    ],
    '/cancelTrip' => [
        'controller' => App\Controller\BookingController::class,
        'method' => 'deleteTrip'
    ],
    '/addReview' => [
        'controller' => App\Controller\ReviewController::class,
        'method' => 'addReview'
    ],
    '/showReviewsReceived'=> [
    'controller' =>App\Controller\ReviewController::class,
    'method' => 'showReviewsReceived'
    ],
    '/showReviewGiven'=> [
    'controller' =>App\Controller\ReviewController::class,
    'method' => 'showReviewGiven'
    ],
    '/userAdmin' => [
    'controller' =>App\Controller\PageController::class,
    'method' => 'userAdmin'
    ],
    '/carpoolingAdmin' => [
    'controller' =>App\Controller\PageController::class,
    'method' => 'carpoolingAdmin'
    ],
    '/employeAdmin' => [
    'controller' =>App\Controller\PageController::class,
    'method' => 'employeAdmin'
    ],
    '/addEmployee' => [
    'controller' =>App\Controller\PageController::class,
    'method' => 'addEmployee'
    ],
    '/addNewEmployee' => [
    'controller' =>App\Controller\EmployeeController::class,
    'method' => 'addNewEmployee'
    ],
    '/dashboardEmployee' => [
    'controller' =>App\Controller\EmployeeController::class,
    'method' => 'dashboardEmployees'
    ],
    '/acceptReview'=> [
    'controller' =>App\Controller\ReviewController::class,
    'method' => 'acceptReview'
    ],
    '/rejectReview'=> [
    'controller' =>App\Controller\ReviewController::class,
    'method' => 'rejectReview'
    ],
    '/api/stats/carpoolings-per-day'=> [
        'controller' =>App\Controller\StatsController::class,
        'method' => 'getCarpoolingsPerDay'
    ],
    '/api/stats/credits-per-day'=> [
        'controller' =>App\Controller\StatsController::class,
        'method' => 'getCreditsPerDay'
    ],


    


    
];