<?php

namespace App\Repository;

use App\Model\Salle;

class SalleRepository implements SalleRepositoryInterface
{
    public function lister(): array
    {
        return Salle::query()
            ->orderBy('nom')
            ->get()
            ->all();
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
}
