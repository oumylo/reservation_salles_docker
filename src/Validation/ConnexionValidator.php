<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class ConnexionValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'email' => v::email(),

            'password' => v::stringType()
                ->notEmpty()
                ->length(1, 255),
        ];

        foreach ($rules as $champ => $regle) {

            try {

                $regle->assert($data[$champ] ?? null);

            } catch (NestedValidationException $e) {

                $errors[$champ] = $e->getMessages();
            }
        }

        return new ValidationResult(
            empty($errors),
            $errors,
            $data
        );
    }
}
