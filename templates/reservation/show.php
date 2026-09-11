<?php

$title = 'Détail de la réservation';

?>

<div class="page-header">

    <div class="page-header-left">

        <h1 class="page-title">Détail de la réservation</h1>

        <p class="page-subtitle">
            Informations concernant cette réservation.
        </p>

    </div>

</div>

<div class="detail-card">

    <ul class="detail-list">


<li>
    <strong>Salle :</strong>

    <span>
        <?= htmlspecialchars(
            $reservation->salle?->nom ?? 'Salle inconnue',
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </span>
</li>

<li>
    <strong>Responsable :</strong>

    <span>
        <?= htmlspecialchars(
            $reservation->responsable,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </span>
</li>

<li>
    <strong>Email :</strong>

    <span>
        <?= htmlspecialchars(
            $reservation->email,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </span>
</li>

<li>
    <strong>Motif :</strong>

    <span>
        <?= htmlspecialchars(
            $reservation->motif,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </span>
</li>

<li>
    <strong>Date de début :</strong>

    <span>
        <?= htmlspecialchars(
            $reservation->date_debut->format('d/m/Y H:i'),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </span>
</li>

<li>
    <strong>Date de fin :</strong>

    <span>
        <?= htmlspecialchars(
            $reservation->date_fin->format('d/m/Y H:i'),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </span>
</li>

<li>
    <strong>Statut :</strong>

    <span>
        <?php if ($reservation->statut === 'confirmée'): ?>

            <span class="badge badge-success">
                Confirmée
            </span>

        <?php else: ?>

            <span class="badge badge-danger">
                Annulée
            </span>

        <?php endif; ?>
    </span>
</li>


</ul>

<div class="detail-actions">


<?php if ($reservation->statut === 'confirmée'): ?>

    <form
        method="POST"
        action="/reservations/<?= (int) $reservation->id ?>/cancel"
    >
        <button
            type="submit"
            class="btn btn-danger"
        >
            Annuler la réservation
        </button>
    </form>

<?php endif; ?>

<a
    href="/reservations"
    class="btn btn-secondary"
>
    Retour à la liste
</a>


</div>

</div>


