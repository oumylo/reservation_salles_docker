<?php

namespace App\Repository;

use App\Model\Reservation;

interface ReservationRepositoryInterface
{
    public function lister();

    public function trouver(int $id): ?Reservation;

    public function rechercherConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin
    ): bool;

    public function existePourSalle(int $salleId): bool;

    public function enregistrer(Reservation $reservation): Reservation;

    public function annuler(int $id): bool;
}
