<?php

$title = 'Liste des salles';

ob_start();
?>

<h1>Liste des salles</h1>

<p>
    <a href="/salles/create">Ajouter une salle</a>
</p>

<?php if (empty($salles)): ?>

    <p>Aucune salle disponible.</p>

<?php else: ?>

    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Bâtiment</th>
                <th>Capacité</th>
                <th>Type</th>
                <th>État</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($salles as $salle): ?>

            <tr>
                <td>
                    <?= htmlspecialchars($salle->nom) ?>
                </td>

                <td>
                    <?= htmlspecialchars($salle->batiment) ?>
                </td>

                <td>
                    <?= htmlspecialchars((string) $salle->capacite) ?>
                </td>

                <td>
                    <?= htmlspecialchars($salle->type) ?>
                </td>

                <td>
                    <?= $salle->active ? 'Active' : 'Inactive' ?>
                </td>

                <td>
                    <a href="/salles/<?= (int) $salle->id ?>">
                        Voir
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

<?php endif; ?>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
