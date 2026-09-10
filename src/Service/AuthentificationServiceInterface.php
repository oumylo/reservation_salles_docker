<?php

namespace App\Service;

use App\DTO\ConnexionDTO;
use App\Model\Responsable;

interface AuthentificationServiceInterface
{
    public function connecter(ConnexionDTO $dto): Responsable;
}
