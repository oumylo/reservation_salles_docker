<?php

namespace App\Validation;

use Respect\Validation\Validator as v;

class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $acceptedData = [];

        $salleIdValide = v::intVal()
            ->positive()
            ->validate($data['salle_id'] ?? null);

        if (!$salleIdValide) {
            $errors['salle_id'][] =
                'La salle doit être un entier positif.';
        } else {
            $acceptedData['salle_id'] = $data['salle_id'];
        }

        $responsableValide = v::stringType()
            ->length(2, 120)
            ->validate($data['responsable'] ?? null);

        if (!$responsableValide) {
            $errors['responsable'][] =
                'Le responsable doit contenir entre 2 et 120 caractères.';
        } else {
            $acceptedData['responsable'] = $data['responsable'];
        }

        $emailValide = v::email()
            ->validate($data['email'] ?? null);

        if (!$emailValide) {
            $errors['email'][] =
                'L’adresse email est invalide.';
        } else {
            $acceptedData['email'] = $data['email'];
        }

        $motifValide = v::stringType()
            ->length(5, 255)
            ->validate($data['motif'] ?? null);

        if (!$motifValide) {
            $errors['motif'][] =
                'Le motif doit contenir entre 5 et 255 caractères.';
        } else {
            $acceptedData['motif'] = $data['motif'];
        }

        $dateDebutValide = v::dateTime()
            ->validate($data['date_debut'] ?? null);

        if (!$dateDebutValide) {
            $errors['date_debut'][] =
                'La date de début est invalide.';
        } else {
            $acceptedData['date_debut'] = $data['date_debut'];
        }

        $dateFinValide = v::dateTime()
            ->validate($data['date_fin'] ?? null);

        if (!$dateFinValide) {
            $errors['date_fin'][] =
                'La date de fin est invalide.';
        } else {
            $acceptedData['date_fin'] = $data['date_fin'];
        }

        return new ValidationResult($errors, $acceptedData);
    }
}