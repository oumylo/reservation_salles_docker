<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;

class ReservationConsultationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister()
    {
        return $this->reservationRepository->lister();
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservationRepository->trouver($id);
    }

    public function listerSalles()
    {
        return $this->salleRepository->lister();
    }
}
