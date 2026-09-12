<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Salle;

interface SalleConsultationServiceInterface
{
    public function lister(int $page = 1);

    public function trouver(int $id): ?Salle;
}