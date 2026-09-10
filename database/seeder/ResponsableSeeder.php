<?php

use Illuminate\Database\Capsule\Manager as Capsule;

return function (Capsule $capsule): void {

    $capsule
        ->table('responsables')
        ->updateOrInsert(
            [
                'email' => 'admin@example.com',
            ],
            [
                'nom' => 'Administrateur',
                'password' => password_hash(
                    'admin123',
                    PASSWORD_DEFAULT
                ),
                'role' => 'ADMIN',
            ]
        );

    $capsule
        ->table('responsables')
        ->updateOrInsert(
            [
                'email' => 'responsable@example.com',
            ],
            [
                'nom' => 'Responsable Test',
                'password' => password_hash(
                    'responsable123',
                    PASSWORD_DEFAULT
                ),
                'role' => 'RESPONSABLE',
            ]
        );
};