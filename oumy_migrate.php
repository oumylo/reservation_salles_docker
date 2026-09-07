<?php


require __DIR__ . '/vendor/autoload.php';


$capsule = require __DIR__ . '/config/database.php';


$schema = $capsule->schema();


if (!$schema->hasTable('migrations')) {

    $schema->create('migrations', function ($table) {

        $table->id();

        $table->string('migration')->unique();

        $table->timestamp('executed_at')->useCurrent();
    });

    echo "Table technique 'migrations' créée.\n";
}



$migrationsPath = __DIR__ . '/database/migrations';


if (!is_dir($migrationsPath)) {

    echo "Erreur : le dossier database/migrations n'existe pas.\n";

    exit(1);
}

$migrations = glob($migrationsPath . '/*.php');


sort($migrations);


if (empty($migrations)) {

    echo "Aucune migration trouvée.\n";

    exit(0);
}

foreach ($migrations as $migration) {

    $migrationName = basename($migration);

    $alreadyExecuted = $capsule
        ->table('migrations')
        ->where('migration', $migrationName)
        ->exists();

    if ($alreadyExecuted) {

        echo "Migration : {$migrationName} ... SKIP\n";

        continue;
    }

    echo "Migration : {$migrationName} ... ";


    try {

        $migrationFunction = require $migration;


        if (!is_callable($migrationFunction)) {

            throw new RuntimeException(
                "La migration {$migrationName} doit retourner une fonction."
            );
        }


        $migrationFunction($capsule);

        $capsule
            ->table('migrations')
            ->insert([
                'migration' => $migrationName,
            ]);


        echo "OK\n";

    } catch (Throwable $e) {


        echo "ERREUR\n";

        echo "Message : " . $e->getMessage() . "\n";

        exit(1);
    }
}


echo "\nToutes les migrations ont été traitées avec succès.\n";
