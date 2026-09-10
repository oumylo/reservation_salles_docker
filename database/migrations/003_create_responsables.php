<?php

use Illuminate\Database\Capsule\Manager as Capsule;

return function (Capsule $capsule): void {

    $schema = $capsule->schema();

    $schema->create('responsables', function ($table) {

        $table->id();

        $table->string('nom');

        $table->string('email')->unique();

        $table->string('password');

        $table->enum('role', [
            'ADMIN',
            'RESPONSABLE'
        ])->default('RESPONSABLE');

        $table->timestamps();
    });
};