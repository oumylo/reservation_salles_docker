<?php

declare(strict_types=1);

namespace App\Service;

use App\Validation\SalleValidator;
use App\Validation\ValidationResult;

class SalleValidationService
{
    public function __construct(
        private SalleValidator $validator,
        private ValidationMessageService $messageService
    ) {
    }

    public function valider(array $data): ValidationResult
    {
        $result = $this->validator->validate($data);

        if ($result->isValid()) {
            return $result;
        }

        $errors = [];

        foreach ($result->errors() as $champ => $codes) {
            $errors[$champ] = $this->messageService->message(
                $champ,
                $codes
            );
        }

        return new ValidationResult(
            false,
            $errors,
            $result->data()
        );
    }
}