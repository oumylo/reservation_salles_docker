<?php

declare(strict_types=1);

use App\Application;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$builder = new ContainerBuilder();

$builder->addDefinitions(
    __DIR__ . '/config/container.php'
);

$container = $builder->build();

$container->get(Capsule::class);

return $container->get(Application::class);