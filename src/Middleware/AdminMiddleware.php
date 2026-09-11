<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Service\AutorisationGuard;

class AdminMiddleware implements MiddlewareInterface
{
    public function __construct(
        private AutorisationGuard $autorisationGuard
    ) {
    }

    public function handle(callable $next): void
    {
     
        $this->autorisationGuard->exigerAdmin();

        $next();
    }
}
