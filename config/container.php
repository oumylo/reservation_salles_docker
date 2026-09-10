<?php

use App\Application;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepository;
use App\Repository\SalleRepositoryInterface;
use App\Repository\ResponsableRepository;
use App\Repository\ResponsableRepositoryInterface;
use App\Service\AuthentificationService;
use App\Service\AuthentificationServiceInterface;
use App\Service\AutorisationService;
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

    SalleRepositoryInterface::class => autowire(
        SalleRepository::class
    ),

    ReservationRepositoryInterface::class => autowire(
        ReservationRepository::class
    ),

    SalleValidator::class => autowire(),

    ReservationValidator::class => autowire(),

    AutorisationService::class => autowire(),

    ResponsableRepositoryInterface::class => autowire(
        ResponsableRepository::class
    ),

    AuthentificationServiceInterface::class => autowire(
        AuthentificationService::class
    ),

    Dispatcher::class => function (): Dispatcher {

        return \FastRoute\simpleDispatcher(
            function (RouteCollector $router): void {

                $routes = require dirname(__DIR__) . '/routes/web.php';

                $routes($router);
            }
        );
    },

    Application::class => autowire(),
];
