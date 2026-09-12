<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;

interface CreerSalleServiceInterface
{
    public function executer(CreerSalleDTO $dto): Salle;
}