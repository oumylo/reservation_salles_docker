<?php

declare(strict_types=1);

namespace App\DTO;

use DateTimeImmutable;

readonly class CreerReservationDTO
{
    public function __construct(
        public int $salleId,
        public string $responsable,
        public string $email,
        public string $motif,
        public DateTimeImmutable $dateDebut,
        public DateTimeImmutable $dateFin
    ) {
    }

    public static function fromToErray(array $donnees): self
    {
        return new self(
            (int) $donnees['salle_id'],
            $donnees['responsable'],
            $donnees['email'],
            $donnees['motif'],
            new DateTimeImmutable($donnees['date_debut']),
            new DateTimeImmutable($donnees['date_fin'])
        );
    }
}
