<?php

declare(strict_types=1);

use App\Application;
use App\DTO\ConnexionBuilder;
use App\DTO\ConnexionBuilderInterface;
use App\DTO\CreerReservationBuilder;
use App\DTO\CreerReservationBuilderInterface;
use App\DTO\CreerSalleBuilder;
use App\DTO\CreerSalleBuilderInterface;
use App\DTO\InscriptionBuilder;
use App\DTO\InscriptionBuilderInterface;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\MiddlewareResolver;
use App\Middleware\MiddlewareResolverInterface;
use App\Middleware\MiddlewareRunner;
use App\Renderer\HtmlRenderer;
use App\Renderer\JsonRenderer;
use App\Renderer\RendererInterface;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\ResponsableRepository;
use App\Repository\ResponsableRepositoryInterface;
use App\Repository\SalleRepository;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\AuthentificationService;
use App\Service\AuthentificationServiceInterface;
use App\Service\AutorisationService;
use App\Service\AutorisationServiceInterface;
use App\Service\CreerReservationService;
use App\Service\CreerReservationServiceInterface;
use App\Service\CreerSalleService;
use App\Service\CreerSalleServiceInterface;
use App\Service\InscriptionService;
use App\Service\InscriptionServiceInterface;
use App\Service\ModifierSalleService;
use App\Service\ModifierSalleServiceInterface;
use App\Service\ReservationConsultationService;
use App\Service\ReservationConsultationServiceInterface;
use App\Service\ReservationDisponibiliteService;
use App\Service\ReservationDisponibiliteServiceInterface;
use App\Service\SalleConsultationService;
use App\Service\SalleConsultationServiceInterface;
use App\Service\SalleStatistiqueService;
use App\Service\SalleStatistiqueServiceInterface;
use App\Service\SupprimerSalleService;
use App\Service\SupprimerSalleServiceInterface;
use App\Service\ValidationMessageInterface;
use App\Service\ValidationMessageService;
use App\Validation\ConnexionValidator;
use App\Validation\ConnexionValidatorInterface;
use App\Validation\InscriptionValidator;
use App\Validation\InscriptionValidatorInterface;
use App\Validation\ReservationValidator;
use App\Validation\ReservationValidatorInterface;
use App\Validation\SalleValidator;
use App\Validation\SalleValidatorInterface;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Illuminate\Database\Capsule\Manager as Capsule;
use function DI\autowire;
use function DI\factory;

return [

    SalleRepositoryInterface::class => autowire(SalleRepository::class),
    ReservationRepositoryInterface::class => autowire(
        ReservationRepository::class
    ),
    ResponsableRepositoryInterface::class => autowire(
        ResponsableRepository::class
    ),


    SalleValidatorInterface::class => autowire(SalleValidator::class),
    ReservationValidatorInterface::class => autowire(
        ReservationValidator::class
    ),
    ConnexionValidatorInterface::class => autowire(
        ConnexionValidator::class
    ),
    InscriptionValidatorInterface::class => autowire(
        InscriptionValidator::class
    ),

   
    CreerSalleBuilderInterface::class => autowire(
        CreerSalleBuilder::class
    ),
    CreerReservationBuilderInterface::class => autowire(
        CreerReservationBuilder::class
    ),
    ConnexionBuilderInterface::class => autowire(
        ConnexionBuilder::class
    ),
    InscriptionBuilderInterface::class => autowire(
        InscriptionBuilder::class
    ),

   
    AuthentificationServiceInterface::class => autowire(
        AuthentificationService::class
    ),
    InscriptionServiceInterface::class => autowire(
        InscriptionService::class
    ),
    AutorisationServiceInterface::class => autowire(
        AutorisationService::class
    ),
    ValidationMessageInterface::class => autowire(
        ValidationMessageService::class
    ),
    ReservationDisponibiliteServiceInterface::class => autowire(
        ReservationDisponibiliteService::class
    ),
    SalleConsultationServiceInterface::class => autowire(
        SalleConsultationService::class
    ),
    SalleStatistiqueServiceInterface::class => autowire(
        SalleStatistiqueService::class
    ),
    CreerSalleServiceInterface::class => autowire(
        CreerSalleService::class
    ),
    ModifierSalleServiceInterface::class => autowire(
        ModifierSalleService::class
    ),
    SupprimerSalleServiceInterface::class => autowire(
        SupprimerSalleService::class
    ),
    ReservationConsultationServiceInterface::class => autowire(
        ReservationConsultationService::class
    ),
    CreerReservationServiceInterface::class => autowire(
        CreerReservationService::class
    ),
    AnnulerReservationServiceInterface::class => autowire(
        AnnulerReservationService::class
    ),

   
    MiddlewareResolverInterface::class => autowire(
        MiddlewareResolver::class
    ),


    Capsule::class => factory(
        static function (): Capsule {
            return require dirname(__DIR__) . '/config/database.php';
        }
    ),

    RendererInterface::class => factory(
        static function (): RendererInterface {
            $format = $_ENV['RESPONSE_FORMAT'] ?? 'html';

            if ($format === 'json') {
                return new JsonRenderer();
            }

            return new HtmlRenderer();
        }
    ),

    
    Dispatcher::class => factory(
        static function (): Dispatcher {
            return \FastRoute\simpleDispatcher(
                static function (RouteCollector $router): void {
                    $routes = require dirname(__DIR__) . '/routes/web.php';

                    $routes($router);
                }
            );
        }
    ),

    Application::class => autowire(),
];