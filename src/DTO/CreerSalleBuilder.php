<?php

declare(strict_types=1);

namespace App\DTO;

use LogicException;


final class CreerSalleBuilder implements CreerSalleBuilderInterface
{
    private ?string $nom = null;
    private ?string $batiment = null;
    private ?int $capacite = null;
    private ?string $type = null;
    private ?bool $active = null;

    public function fromArray(array $donnees): self
    {
        $this->nom = (string) $donnees['nom'];
        $this->batiment = (string) $donnees['batiment'];
        $this->capacite = (int) $donnees['capacite'];
        $this->type = (string) $donnees['type'];
        $this->active = (bool) $donnees['active'];

        return $this;
    }

    public function build(): CreerSalleDTO
    {
        
        return new CreerSalleDTO(
            $this->nom,
            $this->batiment,
            $this->capacite,
            $this->type,
            $this->active
        );
    }
}