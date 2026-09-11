<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Responsable;

interface ResponsableRepositoryInterface
{
    public function trouverParEmail(string $email): ?Responsable;
}
