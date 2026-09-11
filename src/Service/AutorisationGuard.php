<?php

namespace App\Service;

class AutorisationGuard
{
    public function __construct(
        private AutorisationService $autorisationService
    ) {
    }

    public function exigerConnexion(): void
    {
        if (!$this->autorisationService->estConnecte()) {
            header('Location: /login');
            exit;
        }
    }

    public function exigerAdmin(): void
    {
        $this->exigerConnexion();

        if (!$this->autorisationService->estAdmin()) {
            http_response_code(403);

            require dirname(__DIR__, 2) . '/templates/error/403.php';

            exit;
        }
    }
}