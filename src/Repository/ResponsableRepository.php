<?php

namespace App\Repository;

use App\Model\Responsable;

class ResponsableRepository implements ResponsableRepositoryInterface
{
    public function trouverParEmail(string $email): ?Responsable
    {
        return Responsable::query()
            ->where('email', $email)
            ->first();
    }
}
