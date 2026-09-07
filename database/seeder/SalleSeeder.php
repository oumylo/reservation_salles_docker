<?php

use Illuminate\Database\Capsule\Manager as Capsule;


return function (Capsule $capsule): void {

    $capsule->table('salles')->insert([
        [
            'nom' => 'Salle A101',
            'batiment' => 'Bloc A',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ],
        [
            'nom' => 'Salle Informatique 1',
            'batiment' => 'Bloc B',
            'capacite' => 30,
            'type' => 'informatique',
            'active' => true,
        ],
        [
            'nom' => 'Laboratoire 1',
            'batiment' => 'Bloc C',
            'capacite' => 25,
            'type' => 'laboratoire',
            'active' => true,
        ],
        [
            'nom' => 'Amphithéâtre A',
            'batiment' => 'Bloc D',
            'capacite' => 200,
            'type' => 'amphitheatre',
            'active' => true,
        ],
        [
            'nom' => 'Salle Réunion 1',
            'batiment' => 'Bloc E',
            'capacite' => 15,
            'type' => 'reunion',
            'active' => true,
        ],
    ]);
};
