<?php

declare(strict_types=1);

namespace App\DTO;


interface CreerSalleBuilderInterface
{
    public function fromArray(array $donnees): self;

    public function build(): CreerSalleDTO;
}