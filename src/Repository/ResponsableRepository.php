<?php

declare(strict_types=1);

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

    public function emailExiste(string $email): bool
    {
        return Responsable::query()
            ->where('email', $email)
            ->exists();
    }

    public function enregistrer(Responsable $responsable): Responsable
    {
        $responsable->save();

        return $responsable;
    }
}