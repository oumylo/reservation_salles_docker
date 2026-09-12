<?php

namespace App\Repository;

use App\Model\Salle;

interface SalleRepositoryInterface
{
    public function lister(int $page = 1);

    public function listerToutes(): array;

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): Salle;

    public function supprimer(int $id): bool;

    public function sallesLesPlusUtilisees(): array;
}
