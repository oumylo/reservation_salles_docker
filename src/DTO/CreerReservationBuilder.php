<?php

declare(strict_types=1);

namespace App\DTO;

use DateTimeImmutable;
use LogicException;


final class CreerReservationBuilder implements CreerReservationBuilderInterface
{
    private ?int $salleId = null;
    private ?string $responsable = null;
    private ?string $email = null;
    private ?string $motif = null;
    private ?DateTimeImmutable $dateDebut = null;
    private ?DateTimeImmutable $dateFin = null;

    public function fromArray(array $donnees): self
    {
        $this->salleId = (int) $donnees['salle_id'];
        $this->responsable = (string) $donnees['responsable'];
        $this->email = (string) $donnees['email'];
        $this->motif = (string) $donnees['motif'];
        $this->dateDebut = new DateTimeImmutable((string) $donnees['date_debut']);
        $this->dateFin = new DateTimeImmutable((string) $donnees['date_fin']);

        return $this;
    }

    public function build(): CreerReservationDTO
    {
        return new CreerReservationDTO(
            $this->salleId,
            $this->responsable,
            $this->email,
            $this->motif,
            $this->dateDebut,
            $this->dateFin
        );
    }
}