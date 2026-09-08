<?php

namespace App;

use App\Controller\ReservationController;
use App\Controller\SalleController;
use FastRoute\Dispatcher;

final class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private SalleController $salleController,
        private ReservationController $reservationController
    ) {
    }

    public function run(): void
    {
     
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        $routeInfo = $this->dispatcher->dispatch(
            $httpMethod,
            $uri
        );

        switch ($routeInfo[0]) {

            case Dispatcher::NOT_FOUND:

                http_response_code(404);

                require dirname(__DIR__) . '/templates/error/404.php';

                break;

            case Dispatcher::METHOD_NOT_ALLOWED:

                http_response_code(405);

                $allowedMethods = $routeInfo[1];

                header(
                    'Allow: ' . implode(', ', $allowedMethods)
                );

                require dirname(__DIR__) . '/templates/error/405.php';

                break;

            case Dispatcher::FOUND:

                $handler = $routeInfo[1];

                $vars = $routeInfo[2];

                $controller = match ($handler[0]) {

                    SalleController::class =>
                        $this->salleController,

                    ReservationController::class =>
                        $this->reservationController,

                    default => throw new \RuntimeException(
                        'Contrôleur non pris en charge : ' . $handler[0]
                    ),
                };

                $action = $handler[1];

                $controller->$action(...array_values($vars));

                break;
        }
    }
}
