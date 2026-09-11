<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'salle_id' => v::stringType()
                ->notEmpty()
                ->digit(),

            'responsable' => v::stringType()
                ->notEmpty()
                ->length(2, 120),

            'email' => v::stringType()
                ->notEmpty()
                ->email(),

            'motif' => v::stringType()
                ->notEmpty()
                ->length(5, 255),

            'date_debut' => v::stringType()
                ->notEmpty()
                ->dateTime(),

            'date_fin' => v::stringType()
                ->notEmpty()
                ->dateTime(),
        ];

        foreach ($rules as $champ => $regle) {
            try {
                $regle->assert($data[$champ] ?? null);
            } catch (NestedValidationException $exception) {
                $errors[$champ] = array_keys(
                    $exception->getMessages()
                );
            }
        }

        return new ValidationResult(
            empty($errors),
            $errors,
            $data
        );
    }
}
