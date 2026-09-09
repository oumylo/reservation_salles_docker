<?php

namespace App\Service;

use App\Exception\ReservationIntrouvableException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;

class AnnulerReservationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function executer(int $reservationId): Reservation
    {
        $reservation = $this->reservationRepository->trouver($reservationId);

        if ($reservation === null) {
            throw new ReservationIntrouvableException(
                'La réservation demandée est introuvable.'
            );
        }

        $this->reservationRepository->annuler($reservationId);

        $reservation->statut = 'annulée';

        return $reservation;
    }
}
