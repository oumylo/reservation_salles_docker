```php
<?php

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\ReservationRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepository;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use DI\Container;

$container = new Container();


$container->set(
    SalleRepositoryInterface::class,
    \DI\create(SalleRepository::class)
);

$container->set(
    ReservationRepositoryInterface::class,
    \DI\create(ReservationRepository::class)
);

$container->set(
    SalleValidator::class,
    \DI\create(SalleValidator::class)
);

$container->set(
    ReservationValidator::class,
    \DI\create(ReservationValidator::class)
);


$container->set(
    CreerReservationService::class,
    \DI\autowire(CreerReservationService::class)
);

$container->set(
    AnnulerReservationService::class,
    \DI\autowire(AnnulerReservationService::class)
);

$container->set(
    SalleController::class,
    \DI\autowire(SalleController::class)
);

$container->set(
    ReservationController::class,
    \DI\autowire(ReservationController::class)
);

return $container;
