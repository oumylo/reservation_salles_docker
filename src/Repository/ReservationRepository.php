<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function lister()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($page < 1) {
            $page = 1;
        }

        return Reservation::query()
            ->orderBy('date_debut')
            ->paginate(
                4,
                ['*'],
                'page',
                $page
            )
            ->withPath('/reservations');
    }

    public function trouver(int $id): ?Reservation
    {
        return Reservation::find($id);
    }

    public function rechercherConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin
    ): bool {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut)
            ->exists();
    }

    public function existePourSalle(int $salleId): bool
    {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->exists();
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->save();

        return $reservation;
    }

    public function annuler(int $id): bool
    {
        $reservation = $this->trouver($id);

        if ($reservation === null) {
            return false;
        }

        $reservation->statut = 'annulée';

        return $reservation->save();
    }
}
