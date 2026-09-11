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

    public static function fromToErray(array $donnees): self
    {
        return new self(
            $donnees['nom'],
            $donnees['batiment'],
            (int) $donnees['capacite'],
            $donnees['type'],
            (bool) $donnees['active']
        );
    }
}