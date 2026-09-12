<?php

namespace App\Service;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

class SalleConsultationService implements SalleConsultationServiceInterface
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister(int $page = 1)
    {
        return $this->salleRepository->lister($page);
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salleRepository->trouver($id);
    }
}