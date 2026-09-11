<?php

namespace App\Service;

use App\Repository\SalleRepositoryInterface;

class SalleStatistiqueService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function sallesLesPlusUtilisees(): array
    {
        return $this->salleRepository->sallesLesPlusUtilisees();
    }
}
