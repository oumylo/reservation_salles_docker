<?php

declare(strict_types=1);

namespace App\DTO;

readonly class InscriptionDTO
{
    public function __construct(
        public string $nom,
        public string $email,
        public string $password
    ) {
    }
}