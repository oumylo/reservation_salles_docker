<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;

class ReservationDisponibiliteService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function verifier(CreerReservationDTO $dto): void
    {

        $salle = $this->salleRepository->trouver($dto->salleId);

        if ($salle === null) {
            throw new SalleIndisponibleException(
                'La salle demandée n\'existe pas.'
            );
        }

        if (!$salle->active) {
            throw new SalleIndisponibleException(
                'La salle demandée est inactive.'
            );
        }

        if ($dto->dateDebut >= $dto->dateFin) {
            throw new SalleIndisponibleException(
                'La date de début doit précéder la date de fin.'
            );
        }


        $dureeEnSecondes =
            $dto->dateFin->getTimestamp()
            - $dto->dateDebut->getTimestamp();

        if ($dureeEnSecondes > 4 * 3600) {
            throw new SalleIndisponibleException(
                'La durée de réservation ne peut pas dépasser quatre heures.'
            );
        }

        $maintenant = new \DateTimeImmutable();

        if ($dto->dateDebut <= $maintenant) {
            throw new SalleIndisponibleException(
                'La date de début doit être dans le futur.'
            );
        }

   
        $conflit = $this->reservationRepository->rechercherConflit(
            $dto->salleId,
            $dto->dateDebut,
            $dto->dateFin
        );

        if ($conflit) {
            throw new SalleIndisponibleException(
                'La salle est déjà réservée pour cette période.'
            );
        }
    }
}
