<?php

namespace App\Repository;

use App\Model\Salle;

interface SalleRepositoryInterface
{
    public function lister();

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): Salle;

    public function supprimer(int $id): bool;
}
