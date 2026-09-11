<?php

declare(strict_types=1);

namespace App\Service;

use App\Validation\ReservationValidator;
use App\Validation\ValidationResult;

class ReservationValidationService
{
    public function __construct(
        private ReservationValidator $validator,
        private ValidationMessageService $messageService
    ) {
    }

    public function valider(array $data): ValidationResult
    {
        // Le Validator vérifie les règles et retourne les codes d'erreur.
        $result = $this->validator->validate($data);

        // Si aucune erreur, on retourne directement le résultat.
        if ($result->isValid()) {
            return $result;
        }

        $errors = [];

        // On transforme chaque code d'erreur en message français.
        foreach ($result->errors() as $champ => $codes) {
            $errors[$champ] = $this->messageService->message(
                $champ,
                $codes
            );
        }

        // On retourne un nouveau résultat contenant
        // les messages français sous forme de chaînes.
        return new ValidationResult(
            false,
            $errors,
            $result->data()
        );
    }
}
