<?php

declare(strict_types=1);

namespace App\Middleware;

use RuntimeException;

final class MiddlewareResolver implements MiddlewareResolverInterface
{
    public function __construct(
        private AuthMiddleware $authMiddleware,
        private AdminMiddleware $adminMiddleware
    ) {
    }

    public function resolve(array $middlewareClasses): array
    {
        $middlewares = [];

        foreach ($middlewareClasses as $middlewareClass) {
            $middlewares[] = match ($middlewareClass) {
                AuthMiddleware::class => $this->authMiddleware,
                AdminMiddleware::class => $this->adminMiddleware,
                default => throw new RuntimeException(
                    'Middleware non pris en charge : ' . $middlewareClass
                ),
            };
        }

        return $middlewares;
    }
}