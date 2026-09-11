<?php

namespace App\DTO;

final readonly class ConnexionDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }

    public static function fromToErray(array $donnees): self
    {
        return new self(
            $donnees['email'],
            $donnees['password']
        );
    }
}