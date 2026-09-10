<?php

$title = $title ?? 'Gestion des réservations';
$content = $content ?? '';

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="stylesheet" href="/assets/style.css">

    <title>
        <?= htmlspecialchars($title) ?>
    </title>

</head>

<body>

<?php

$estConnecte = isset($_SESSION['responsable_id']);

$estPageConnexion = ($_SERVER['REQUEST_URI'] ?? '') === '/login';

?>

<?php if ($estConnecte && !$estPageConnexion): ?>

    <header>

        <nav>

            <a href="/salles">
                Salles
            </a>

            <a href="/reservations">
                Réservations
            </a>

            <form
                method="POST"
                action="/logout"
                style="display: inline;"
            >

                <button type="submit">
                    Déconnexion
                </button>

            </form>

        </nav>

    </header>

<?php endif; ?>


<main>

    <?= $content ?>

</main>


</body>

</html>
