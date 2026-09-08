<?php

$title = $title ?? 'Gestion des réservations';
$content = $content ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title) ?></title>
</head>

<body>

<header>
    <nav>
        <a href="/salles">Salles</a>
        |
        <a href="/reservations">Réservations</a>
    </nav>
</header>

<main>
    <?= $content ?>
</main>

</body>
</html>
