<?php

namespace App\DTO;

readonly class CreerSalleDTO
{
    public function __construct(
        public string $nom,
        public string $batiment,
        public int $capacite,
        public string $type,
        public bool $active
    ) {
    }
}