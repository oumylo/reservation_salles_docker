<?php

declare(strict_types=1);

namespace App\Service;

interface SalleStatistiqueServiceInterface
{
    public function sallesLesPlusUtilisees(): array;
}