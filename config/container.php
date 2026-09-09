<?php

use App\Application;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepository;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Illuminate\Database\Capsule\Manager as Capsule;
use function DI\autowire;

return [

    Capsule::class => function (): Capsule 
    { 
        return require dirname(__DIR__) . '/config/database.php'; 
    },

    SalleRepositoryInterface::class => autowire(SalleRepository::class),

    ReservationRepositoryInterface::class => autowire(ReservationRepository::class),

    SalleValidator::class => autowire(),

    ReservationValidator::class => autowire(),

    CreerReservationService::class => autowire(),

    AnnulerReservationService::class => autowire(),

    SalleController::class => autowire(),

    ReservationController::class => autowire(),

    Dispatcher::class => function (): Dispatcher {

        return \FastRoute\simpleDispatcher(
            function (RouteCollector $router): void {

                $routes = require dirname(__DIR__) . '/routes/web.php';

                $routes($router);
            }
        );
    },

    Application::class => function (
    Dispatcher $dispatcher,
    SalleController $salleController,
    ReservationController $reservationController,
    Capsule $capsule
    ): Application {
        return new Application(
            $dispatcher,
            $salleController,
            $reservationController
        );
    },
];
