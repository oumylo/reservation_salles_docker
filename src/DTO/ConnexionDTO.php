<?php

namespace App\DTO;

final readonly class ConnexionDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
