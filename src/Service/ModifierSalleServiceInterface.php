<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;

interface ModifierSalleServiceInterface
{
    public function executer(int $id, CreerSalleDTO $dto): Salle;
}