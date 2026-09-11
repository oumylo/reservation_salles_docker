<?php

namespace App\Repository;

use App\Model\Salle;

class SalleRepository implements SalleRepositoryInterface
{
    public function lister(int $page = 1)
    {
        
        if ($page < 1) {
            $page = 1;
        }

        return Salle::query()
            ->orderBy('nom')
            ->paginate(
                4,
                ['*'],
                'page',
                $page
            );
    }

    public function trouver(int $id): ?Salle
    {
        return Salle::find($id);
    }

    public function enregistrer(Salle $salle): Salle
    {
        $salle->save();

        return $salle;
    }

    public function supprimer(int $id): bool
    {
        $salle = $this->trouver($id);

        if ($salle === null) {
            return false;
        }

        return $salle->delete();
    }

    public function sallesLesPlusUtilisees(): array
    {
        return Salle::query()
            ->select(
                'salles.id',
                'salles.nom',
                'salles.batiment'
            )
            ->join(
                'reservations',
                'reservations.salle_id',
                '=',
                'salles.id'
            )
            ->where('reservations.statut', 'confirmée')
            ->selectRaw('COUNT(reservations.id) as nombre_reservations')
            ->groupBy(
                'salles.id',
                'salles.nom',
                'salles.batiment'
            )
            ->orderByDesc('nombre_reservations')
            ->get()
            ->toArray();
    }
}