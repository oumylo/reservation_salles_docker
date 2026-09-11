<?php

declare(strict_types=1);

namespace App\Middleware;

interface MiddlewareResolverInterface
{
   
    public function resolve(array $middlewareClasses): array;
}
