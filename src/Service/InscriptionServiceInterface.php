<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InscriptionDTO;
use App\Model\Responsable;

interface InscriptionServiceInterface
{
    public function executer(InscriptionDTO $dto): Responsable;
}