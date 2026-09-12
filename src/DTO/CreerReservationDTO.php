<?php

namespace App\DTO;

readonly class CreerReservationDTO
{
    public function __construct(
        public int $salleId,
        public string $responsable,
        public string $email,
        public string $motif,
        public \DateTimeImmutable $dateDebut,
        public \DateTimeImmutable $dateFin
    ) {
    }
}
