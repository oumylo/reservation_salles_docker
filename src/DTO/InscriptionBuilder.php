<?php

declare(strict_types=1);

namespace App\DTO;

use LogicException;


final class InscriptionBuilder implements InscriptionBuilderInterface
{
    private ?string $nom = null;
    private ?string $email = null;
    private ?string $password = null;

    public function fromArray(array $donnees): self
    {
        $this->nom = (string) $donnees['nom'];
        $this->email = (string) $donnees['email'];
        $this->password = (string) $donnees['password'];

        return $this;
    }

    public function build(): InscriptionDTO
    {

        return new InscriptionDTO(
            $this->nom,
            $this->email,
            $this->password
        );
    }
}