<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;

final class ContainerMiddlewareResolver implements MiddlewareResolverInterface
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function resolve(array $middlewareClasses): array
    {
        return array_map(
            fn (string $middlewareClass): MiddlewareInterface =>
                $this->container->get($middlewareClass),
            $middlewareClasses
        );
    }
}
