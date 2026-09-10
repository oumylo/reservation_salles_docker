<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Exception\SalleNonTrouveeException;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

class ModifierSalleService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function executer(int $id, CreerSalleDTO $dto): Salle
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            throw new SalleNonTrouveeException(
                'La salle demandée n\'existe pas.'
            );
        }

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