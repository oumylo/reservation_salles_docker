<?php

namespace App\Validation;

use Respect\Validation\Validator as v;

class ConnexionValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $acceptedData = [];

        $emailValide = v::email()
            ->validate($data['email'] ?? null);

        if (!$emailValide) {
            $errors['email'][] =
                'L’adresse email est invalide.';
        } else {
            $acceptedData['email'] = $data['email'];
        }

        $passwordValide = v::stringType()
            ->notEmpty()
            ->length(1, 255)
            ->validate($data['password'] ?? null);

        if (!$passwordValide) {
            $errors['password'][] =
                'Le mot de passe est obligatoire.';
        } else {
            $acceptedData['password'] = $data['password'];
        }

        return new ValidationResult(
            $errors,
            $acceptedData
        );
    }
}
