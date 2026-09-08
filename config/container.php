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
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Illuminate\Database\Capsule\Manager as Capsule;
use function DI\autowire;

return [

    Capsule::class => function (): Capsule {

        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => $_ENV['DB_DRIVER'],
            'host'      => $_ENV['DB_HOST'],
            'port'      => $_ENV['DB_PORT'],
            'database'  => $_ENV['DB_DATABASE'],
            'username'  => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
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
