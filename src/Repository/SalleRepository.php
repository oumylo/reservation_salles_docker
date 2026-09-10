<?php

namespace App\Repository;

use App\Model\Salle;

class SalleRepository implements SalleRepositoryInterface
{
    public function lister()
    {
        // On récupère le numéro de page envoyé dans l'URL.
        // Exemple : /salles?page=2
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        // Si quelqu'un met ?page=0 ou une valeur négative,
        // on revient à la première page.
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
}
