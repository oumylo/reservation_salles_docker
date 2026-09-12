<?php

declare(strict_types=1);

namespace App;

use App\Controller\AuthController;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Middleware\MiddlewareResolverInterface;
use App\Middleware\MiddlewareRunner;
use FastRoute\Dispatcher;
use RuntimeException;

final class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private SalleController $salleController,
        private ReservationController $reservationController,
        private AuthController $authController,
        private MiddlewareRunner $middlewareRunner,
        private MiddlewareResolverInterface $middlewareResolver
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
                return;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);

                header(
                    'Allow: ' . implode(', ', $routeInfo[1])
                );

                require dirname(__DIR__) . '/templates/error/405.php';
                return;

            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                $controller = match ($handler[0]) {
                    SalleController::class => $this->salleController,
                    ReservationController::class => $this->reservationController,
                    AuthController::class => $this->authController,
                    default => throw new RuntimeException(
                        'Contrôleur non pris en charge : ' . $handler[0]
                    ),
                };

                $action = $handler[1];
                $middlewareClasses = $handler[2] ?? [];

                $middlewares = $this->middlewareResolver->resolve(
                    $middlewareClasses
                );

                $params = array_map(
                    static function (string $value): int {
                        return (int) $value;
                    },
                    $vars
                );

                $this->middlewareRunner->run(
                    $middlewares,
                    function () use (
                        $controller,
                        $action,
                        $params
                    ): void {
                        $controller->$action(...array_values($params));
                    }
                );

                return;
        }
    }
}
