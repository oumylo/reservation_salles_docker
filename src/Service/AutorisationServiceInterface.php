<?php

namespace App\Service;

interface AutorisationServiceInterface
{
    public function estConnecte(): bool;

    public function estAdmin(): bool;
}