<?php


require __DIR__ . '/vendor/autoload.php';


$capsule = require __DIR__ . '/config/database.php';

$schema = $capsule->schema();

if (!$schema->hasTable('seeders')) {

    $schema->create('seeders', function ($table) {

        $table->id();

        $table->string('seeder')->unique();

        $table->timestamp('executed_at')->useCurrent();
    });

    echo "Table technique 'seeders' créée.\n";
}



$seederPath = __DIR__ . '/database/seeder';


if (!is_dir($seederPath)) {

    echo "Erreur : le dossier database/seeder n'existe pas.\n";

    exit(1);
}


$seeders = glob($seederPath . '/*.php');

sort($seeders);

if (empty($seeders)) {

    echo "Aucun seeder trouvé.\n";

    exit(0);
}



foreach ($seeders as $seeder) {

    $seederName = basename($seeder);

    echo "Seeder : {$seederName} ... ";


    try {

        
        $seederFunction = require $seeder;

        if (!is_callable($seederFunction)) {

            throw new RuntimeException(
                "Le seeder {$seederName} doit retourner une fonction."
            );
        }
        $seederFunction($capsule);
        
        $alreadyRecorded = $capsule
            ->table('seeders')
            ->where('seeder', $seederName)
            ->exists();

        if (!$alreadyRecorded) {

            $capsule
                ->table('seeders')
                ->insert([
                    'seeder' => $seederName,
                ]);
        }


        echo "OK\n";

    } catch (Throwable $e) {

        echo "ERREUR\n";

        echo "Message : " . $e->getMessage() . "\n";

        exit(1);
    }
}


echo "\nTous les seeders ont été traités avec succès.\n";
