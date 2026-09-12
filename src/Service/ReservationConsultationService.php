<?php

namespace App\Service;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;

class ReservationConsultationService implements ReservationConsultationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister(int $page = 1)
    {
        return $this->reservationRepository->lister($page);
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservationRepository->trouver($id);
    }

    public function listerSalles()
    {
        return $this->salleRepository->listerToutes();
    }
}