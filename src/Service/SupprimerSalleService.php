<?php

namespace App\Service;

use App\Exception\SalleAvecReservationsException;
use App\Exception\SalleNonTrouveeException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;

class SupprimerSalleService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function executer(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            throw new SalleNonTrouveeException(
                'La salle demandée n\'existe pas.'
            );
        }

        if ($this->reservationRepository->existePourSalle($id)) {
            throw new SalleAvecReservationsException(
                'Cette salle possède des réservations. '
                . 'Suppression impossible. '
                . 'Vous pouvez désactiver la salle à la place.'
            );
        }

        $this->salleRepository->supprimer($id);
    }
}
