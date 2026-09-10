<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

class SalleConsultationService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister()
    {
        return $this->salleRepository->lister();
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salleRepository->trouver($id);
    }
}