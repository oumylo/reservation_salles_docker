<?php

use App\Model\Salle;
use Illuminate\Database\Capsule\Manager as Capsule;

return function (Capsule $capsule): void {

    Salle::updateOrCreate(
        [
            'nom' => 'Amphithéâtre A',
        ],
        [
            'batiment' => 'Bloc A',
            'capacite' => 250,
            'type' => 'amphitheatre',
            'active' => true,
        ]
    );

    Salle::updateOrCreate(
        [
            'nom' => 'Salle B12',
        ],
        [
            'batiment' => 'Bloc B',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ]
    );

    Salle::updateOrCreate(
        [
            'nom' => 'Laboratoire Chimie',
        ],
        [
            'batiment' => 'Bloc C',
            'capacite' => 24,
            'type' => 'laboratoire',
            'active' => true,
        ]
    );

    Salle::updateOrCreate(
        [
            'nom' => 'Salle Informatique 1',
        ],
        [
            'batiment' => 'Bloc D',
            'capacite' => 30,
            'type' => 'informatique',
            'active' => true,
        ]
    );

    Salle::updateOrCreate(
        [
            'nom' => 'Salle de réunion',
        ],
        [
            'batiment' => 'Bloc E',
            'capacite' => 12,
            'type' => 'reunion',
            'active' => true,
        ]
    );
};
