<?php

namespace App\Service;

class AutorisationService
{
    public function estConnecte(): bool
    {
        return isset($_SESSION['responsable_id']);
    }

    public function estAdmin(): bool
    {
        return $this->estConnecte()
            && ($_SESSION['responsable_role'] ?? null) === 'ADMIN';
    }
}