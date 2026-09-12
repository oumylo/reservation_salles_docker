<?php

declare(strict_types=1);

namespace App\DTO;

use LogicException;


final class ConnexionBuilder implements ConnexionBuilderInterface
{
    private ?string $email = null;
    private ?string $password = null;

    public function fromArray(array $donnees): self
    {
        $this->email = (string) $donnees['email'];
        $this->password = (string) $donnees['password'];

        return $this;
    }

    public function build(): ConnexionDTO
    {
        if ($this->email === null || $this->password === null) {
            throw new LogicException(
                'Le Builder de connexion doit être initialisé avec fromArray() avant build().'
            );
        }

        return new ConnexionDTO(
            $this->email,
            $this->password
        );
    }
}