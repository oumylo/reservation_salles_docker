<?php

declare(strict_types=1);

namespace App\Service;

use App\Validation\ReservationValidator;
use App\Validation\ValidationResult;

class ReservationValidationService
{
    public function __construct(
        private ReservationValidator $validator
    ) {
    }

    public function valider(array $data): ValidationResult
    {
        return $this->validator->validate($data);
    }
}