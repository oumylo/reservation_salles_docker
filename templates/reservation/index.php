<?php

$title = 'Liste des réservations';

ob_start();
?>

<h1>Liste des réservations</h1>

<p>
    <a href="/reservations/create">Nouvelle réservation</a>
</p>

<?php if (empty($reservations)): ?>

    <p>Aucune réservation trouvée.</p>

<?php else: ?>

    <table border="1">
        <thead>
            <tr>
                <th>Salle</th>
                <th>Responsable</th>
                <th>Email</th>
                <th>Motif</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($reservations as $reservation): ?>

            <tr>
                <td>
                    <?= htmlspecialchars( $reservation->salle?->nom ?? 'Salle inconnue', ENT_QUOTES, 'UTF-8' ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(  $reservation->responsable, ENT_QUOTES, 'UTF-8' ) ?>
                </td>

                <td>
                    <?= htmlspecialchars( $reservation->email,ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars(  $reservation->motif, ENT_QUOTES,'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars( $reservation->date_debut->format('d/m/Y H:i'), ENT_QUOTES, 'UTF-8' ) ?>
                </td>

                <td>
                    <?= htmlspecialchars( $reservation->date_fin->format('d/m/Y H:i'), ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars( $reservation->statut, ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <a href="/reservations/<?= (int) $reservation->id ?>">  Voir </a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

<?php endif; ?>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
