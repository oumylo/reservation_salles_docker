<?php

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Controller\AuthController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use FastRoute\RouteCollector;

return function (RouteCollector $router): void {

    $router->addRoute(
        'GET',
        '/login',
        [AuthController::class, 'login']
    );

    $router->addRoute(
        'POST',
        '/login',
        [AuthController::class, 'authenticate']
    );

    $router->addRoute(
        'POST',
        '/logout',
        [AuthController::class, 'logout']
    );

    $router->addRoute(
        'GET',
        '/',
        [
            SalleController::class,
            'index',
            [
                AuthMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/salles',
        [
            SalleController::class,
            'index',
            [
                AuthMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/salles/{id:\d+}',
        [
            SalleController::class,
            'show',
            [
                AuthMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/reservations',
        [
            ReservationController::class,
            'index',
            [
                AuthMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/reservations/{id:\d+}',
        [
            ReservationController::class,
            'show',
            [
                AuthMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/salles/create',
        [
            SalleController::class,
            'create',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'POST',
        '/salles',
        [
            SalleController::class,
            'store',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/salles/{id:\d+}/edit',
        [
            SalleController::class,
            'edit',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'POST',
        '/salles/{id:\d+}/edit',
        [
            SalleController::class,
            'update',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'POST',
        '/salles/{id:\d+}/delete',
        [
            SalleController::class,
            'delete',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'GET',
        '/reservations/create',
        [
            ReservationController::class,
            'create',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'POST',
        '/reservations',
        [
            ReservationController::class,
            'store',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );

    $router->addRoute(
        'POST',
        '/reservations/{id:\d+}/cancel',
        [
            ReservationController::class,
            'cancel',
            [
                AuthMiddleware::class,
                AdminMiddleware::class
            ]
        ]
    );
};
