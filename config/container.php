<?php

use App\Application;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepository;
use App\Repository\SalleRepositoryInterface;
use App\Repository\ResponsableRepository;
use App\Repository\ResponsableRepositoryInterface;
use App\Renderer\HtmlRenderer;
use App\Renderer\JsonRenderer;
use App\Renderer\RendererInterface;
use App\Service\AuthentificationService;
use App\Service\AuthentificationServiceInterface;
use App\Service\ReservationConsultationService;
use App\Service\AutorisationService;
use App\Service\AutorisationGuard;
use App\Service\ModifierSalleService;
use App\Service\SalleConsultationService;
use App\Service\SalleValidationService;
use App\Service\ReservationDisponibiliteService;
use App\Service\ValidationMessageService;
use App\Validation\ConnexionValidator;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\MiddlewareRunner;
use App\Middleware\MiddlewareResolverInterface;
use App\Middleware\ContainerMiddlewareResolver;
use Illuminate\Database\Capsule\Manager as Capsule;
use function DI\autowire;
use function DI\factory;

return [

    Capsule::class => function (): Capsule {
        return require dirname(__DIR__) . '/config/database.php';
    },

    SalleRepositoryInterface::class => autowire(
        SalleRepository::class
    ),

    ReservationRepositoryInterface::class => autowire(
        ReservationRepository::class
    ),

    ResponsableRepositoryInterface::class => autowire(
        ResponsableRepository::class
    ),

    SalleValidator::class => autowire(),

    ReservationConsultationService::class => autowire(),

    ReservationValidator::class => autowire(),

    ConnexionValidator::class => autowire(),

    AutorisationService::class => autowire(),

    AutorisationGuard::class => autowire(),

    AuthMiddleware::class => autowire(),

    AdminMiddleware::class => autowire(),

    MiddlewareRunner::class => autowire(),

    MiddlewareResolverInterface::class => autowire(
        ContainerMiddlewareResolver::class
    ),

    SalleConsultationService::class => autowire(),

    SalleValidationService::class => autowire(),

    ValidationMessageService::class => autowire(),

    ReservationDisponibiliteService::class => autowire(),

    AuthentificationServiceInterface::class => autowire(
        AuthentificationService::class
    ),

    ModifierSalleService::class => autowire(),


    RendererInterface::class => factory(
        function (): RendererInterface {

            $format = $_ENV['RESPONSE_FORMAT'] ?? 'html';

            if ($format === 'json') {
                return new JsonRenderer();
            }

            return new HtmlRenderer();
        }
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