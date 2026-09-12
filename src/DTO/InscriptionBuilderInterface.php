<?php

declare(strict_types=1);

namespace App\DTO;


interface InscriptionBuilderInterface
{
    public function fromArray(array $donnees): self;

    public function build(): InscriptionDTO;
}