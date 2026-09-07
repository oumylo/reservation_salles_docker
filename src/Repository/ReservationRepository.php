<?php

namespace App\Repository;

use App\Model\Reservation;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function lister(): array
    {
        return Reservation::query()
            ->orderBy('date_debut')
            ->get()
            ->all();
    }

    public function trouver(int $id): ?Reservation
    {
        return Reservation::find($id);
    }

    public function rechercherConflit(int $salleId, \DateTimeImmutable $dateDebut, \DateTimeImmutable $dateFin
    ): bool {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut)
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
