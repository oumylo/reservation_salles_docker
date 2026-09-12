<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;

class CreerReservationService implements CreerReservationServiceInterface
{
    public function __construct(
        private ReservationDisponibiliteServiceInterface $disponibiliteService,
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function executer(CreerReservationDTO $dto): Reservation
    {
        $this->disponibiliteService->verifier($dto);

        $reservation = new Reservation();

        $reservation->salle_id = $dto->salleId;
        $reservation->responsable = $dto->responsable;
        $reservation->email = $dto->email;
        $reservation->motif = $dto->motif;
        $reservation->date_debut = $dto->dateDebut;
        $reservation->date_fin = $dto->dateFin;
        $reservation->statut = 'confirmée';

        return $this->reservationRepository->enregistrer($reservation);
    }
}