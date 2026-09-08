<?php

$title = 'Détail de la salle';

ob_start();
?>

<h1>Détail de la salle</h1>

<ul>
    <li>
        <strong>Nom :</strong>
        <?= htmlspecialchars($salle->nom, ENT_QUOTES, 'UTF-8') ?>
    </li>

    <li>
        <strong>Bâtiment :</strong>
        <?= htmlspecialchars($salle->batiment, ENT_QUOTES, 'UTF-8') ?>
    </li>

    <li>
        <strong>Capacité :</strong>
        <?= (int) $salle->capacite ?>
    </li>

    <li>
        <strong>Type :</strong>
        <?= htmlspecialchars($salle->type, ENT_QUOTES, 'UTF-8') ?>
    </li>

    <li>
        <strong>État :</strong>
        <?= $salle->active ? 'Active' : 'Inactive' ?>
    </li>
</ul>

<p>
    <a href="/salles">Retour à la liste</a>
</p>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
