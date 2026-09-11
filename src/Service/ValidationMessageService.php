<?php

declare(strict_types=1);

namespace App\Service;

final class ValidationMessageService
{
    public function message(string $champ, array $codes): string
    {
        
        $code = in_array('notEmpty', $codes, true)
            ? 'notEmpty'
            : ($codes[0] ?? null);

        return match ($champ) {


            'nom' => match ($code) {
                'notEmpty' => 'Le nom de la salle est obligatoire.',
                'length' => 'Le nom de la salle doit contenir entre 2 et 100 caractères.',
                'stringType' => 'Le nom de la salle doit être une chaîne de caractères.',
                default => 'Le nom de la salle est invalide.',
            },

            'batiment' => match ($code) {
                'notEmpty' => 'Le bâtiment est obligatoire.',
                'length' => 'Le bâtiment doit contenir entre 2 et 100 caractères.',
                'stringType' => 'Le bâtiment doit être une chaîne de caractères.',
                default => 'Le bâtiment est invalide.',
            },

            'capacite' => match ($code) {
                'intVal' => 'La capacité doit être un nombre entier.',
                'between' => 'La capacité doit être comprise entre 1 et 1000.',
                default => 'La capacité est invalide.',
            },

            'type' => match ($code) {
                'in' => 'Veuillez sélectionner un type de salle valide.',
                default => 'Le type de salle est invalide.',
            },

            'active' => match ($code) {
                'boolType' => 'Le statut de la salle est invalide.',
                default => 'Le statut de la salle est invalide.',
            },


            'salle_id' => match ($code) {
                'notEmpty' => 'Veuillez sélectionner une salle.',
                'digit' => 'La salle sélectionnée est invalide.',
                'stringType' => 'La salle sélectionnée est invalide.',
                default => 'La salle sélectionnée est invalide.',
            },

            'responsable' => match ($code) {
                'notEmpty' => 'Le responsable est obligatoire.',
                'length' => 'Le responsable doit contenir entre 2 et 120 caractères.',
                'stringType' => 'Le responsable doit être une chaîne de caractères.',
                default => 'Le responsable est invalide.',
            },

            'email' => match ($code) {
                'notEmpty' => 'L\'adresse email est obligatoire.',
                'email' => 'Veuillez saisir une adresse email valide.',
                'stringType' => 'L\'adresse email doit être une chaîne de caractères.',
                default => 'L\'adresse email est invalide.',
            },

            'motif' => match ($code) {
                'notEmpty' => 'Le motif est obligatoire.',
                'length' => 'Le motif doit contenir entre 5 et 255 caractères.',
                'stringType' => 'Le motif doit être une chaîne de caractères.',
                default => 'Le motif est invalide.',
            },

            'date_debut' => match ($code) {
                'notEmpty' => 'La date de début est obligatoire.',
                'dateTime' => 'La date de début est invalide.',
                'stringType' => 'La date de début est invalide.',
                default => 'La date de début est invalide.',
            },

            'date_fin' => match ($code) {
                'notEmpty' => 'La date de fin est obligatoire.',
                'dateTime' => 'La date de fin est invalide.',
                'stringType' => 'La date de fin est invalide.',
                default => 'La date de fin est invalide.',
            },

            default => 'La valeur saisie est invalide.',
        };
    }
}
