<?php

$title = 'Détail de la réservation';

ob_start();
?>

<h1>Détail de la réservation</h1>

<ul>

    <li>
        <strong>Salle :</strong>

        <?= htmlspecialchars(
            $reservation->salle?->nom ?? 'Salle inconnue',
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

    <li>
        <strong>Responsable :</strong>

        <?= htmlspecialchars(
            $reservation->responsable,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

    <li>
        <strong>Email :</strong>

        <?= htmlspecialchars(
            $reservation->email,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

    <li>
        <strong>Motif :</strong>

        <?= htmlspecialchars(
            $reservation->motif,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

    <li>
        <strong>Date de début :</strong>

        <?= htmlspecialchars(
            $reservation->date_debut->format('d/m/Y H:i'),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

    <li>
        <strong>Date de fin :</strong>

        <?= htmlspecialchars(
            $reservation->date_fin->format('d/m/Y H:i'),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

    <li>
        <strong>Statut :</strong>

        <?= htmlspecialchars(
            $reservation->statut,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </li>

</ul>

<?php if ($reservation->statut === 'confirmée'): ?>

    <form method="POST"
          action="/reservations/<?= (int) $reservation->id ?>/cancel">

        <button type="submit">
            Annuler la réservation
        </button>

    </form>

<?php endif; ?>

<p>
    <a href="/reservations">
        Retour à la liste
    </a>
</p>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
