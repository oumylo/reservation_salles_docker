<?php

namespace App\Service;

interface ValidationMessageInterface
{
    public function message(string $champ, array $codes): string;
}
