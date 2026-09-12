<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class InscriptionValidator implements InscriptionValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'nom' => v::stringType()
                ->notEmpty()
                ->length(2, 100),

            'email' => v::stringType()
                ->notEmpty()
                ->email(),

            'password' => v::stringType()
                ->notEmpty()
                ->length(8, 255),
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


        if (
            !isset($errors['password'])
            && (
                ($data['password'] ?? null)
                !== ($data['password_confirmation'] ?? null)
            )
        ) {
            $errors['password_confirmation'] = ['confirmation'];
        }

        return new ValidationResult(
            empty($errors),
            $errors,
            $data
        );
    }
}