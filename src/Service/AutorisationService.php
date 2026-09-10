<?php

namespace App\Service;

use RuntimeException;

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

    public function exigerConnexion(): void
    {
        if (!$this->estConnecte()) {
            header('Location: /login');
            exit;
        }
    }

    public function exigerAdmin(): void
    {
        $this->exigerConnexion();

        if (!$this->estAdmin()) {
            http_response_code(403);

            require dirname(__DIR__, 2) . '/templates/error/403.php';

            exit;
        }
    }
}

