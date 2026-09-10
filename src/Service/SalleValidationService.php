<?php

declare(strict_types=1);

namespace App\Service;

use App\Validation\SalleValidator;
use App\Validation\ValidationResult;

class SalleValidationService
{
    public function __construct(
        private SalleValidator $validator
    ) {
    }

    public function valider(array $data): ValidationResult
    {
        return $this->validator->validate($data);
    }
}