<?php

namespace App\Validation;

use Respect\Validation\Validator as v;

class SalleValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $acceptedData = [];


        $nomValide = v::stringType()
            ->notEmpty()
            ->length(2, 100)
            ->validate($data['nom'] ?? null);

        if (!$nomValide) {
            $errors['nom'] =
                'Le nom est obligatoire et doit contenir entre 2 et 100 caractères.';
        } else {
            $acceptedData['nom'] = $data['nom'];
        }

        $batimentValide = v::stringType()
            ->notEmpty()
            ->length(2, 100)
            ->validate($data['batiment'] ?? null);

        if (!$batimentValide) {
            $errors['batiment'] =
                'Le bâtiment est obligatoire et doit contenir entre 2 et 100 caractères.';
        } else {
            $acceptedData['batiment'] = $data['batiment'];
        }

        $capaciteValide = v::intVal()
            ->between(1, 1000)
            ->validate($data['capacite'] ?? null);

        if (!$capaciteValide) {
            $errors['capacite'] =
                'La capacité doit être un entier compris entre 1 et 1000.';
        } else {
            $acceptedData['capacite'] = $data['capacite'];
        }

        $typesAutorises = [
            'cours',
            'informatique',
            'laboratoire',
            'amphitheatre',
            'reunion',
        ];

        $typeValide = v::in($typesAutorises)
            ->validate($data['type'] ?? null);

        if (!$typeValide) {
            $errors['type'] = 'Le type de salle est invalide.';
        } else {
            $acceptedData['type'] = $data['type'];
        }

        $activeValide = v::boolType()
            ->validate($data['active'] ?? null);

        if (!$activeValide) {
            $errors['active'] =
                'Le champ active doit être un booléen.';
        } else {
            $acceptedData['active'] = $data['active'];
        }

        return new ValidationResult(
            $errors,
            $acceptedData
        );
    }
}
