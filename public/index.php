<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$capsule = require dirname(__DIR__) . '/config/database.php';

try {
    $capsule->connection()->getPdo();

    echo "Connexion Eloquent à MySQL OK !";
} catch (\Throwable $e) {
    echo "Erreur de connexion à MySQL : " . $e->getMessage();
}