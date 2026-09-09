<?php

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

class CreerSalleService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function executer(CreerSalleDTO $dto): Salle
    {
        $salle = new Salle();

        $salle->fill([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active,
        ]);

        return $this->salleRepository->enregistrer($salle);
    }
}
