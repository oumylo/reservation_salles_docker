<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Service\AutorisationGuard;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private AutorisationGuard $autorisationGuard
    ) {
    }

    public function handle(callable $next): void
    {
        
        $this->autorisationGuard->exigerConnexion();

        $next();
    }
}

