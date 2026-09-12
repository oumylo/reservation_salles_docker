<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Reservation;

interface ReservationConsultationServiceInterface
{
    public function lister(int $page = 1);

    public function trouver(int $id): ?Reservation;

    public function listerSalles();
}