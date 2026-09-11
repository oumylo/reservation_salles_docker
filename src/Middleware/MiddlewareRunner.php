<?php

declare(strict_types=1);

namespace App\Middleware;

class MiddlewareRunner
{
   
    public function run(
        array $middlewares,
        callable $controller
    ): void {
        $next = $controller;

       
        foreach (array_reverse($middlewares) as $middleware) {
            $next = function () use ($middleware, $next): void {
                $middleware->handle($next);
            };
        }

        
        $next();
    }
}
