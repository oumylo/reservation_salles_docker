<?php

declare(strict_types=1);

namespace App\DTO;


interface CreerReservationBuilderInterface
{
    public function fromArray(array $donnees): self;

    public function build(): CreerReservationDTO;
}