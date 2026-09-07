<?php

use Illuminate\Database\Capsule\Manager as Capsule;

return function (Capsule $capsule): void {

    $schema = $capsule->schema();

    $schema->create('reservations', function ($table) {

        $table->id();

        $table->foreignId('salle_id')
            ->constrained('salles')
            ->restrictOnDelete();

        $table->string('responsable');

        $table->string('email');

        $table->string('motif', 255);

        $table->dateTime('date_debut');

        $table->dateTime('date_fin');

        $table->enum('statut', [
            'confirmée',
            'annulée'
        ])->default('confirmée');

        $table->timestamps();
    });
};
