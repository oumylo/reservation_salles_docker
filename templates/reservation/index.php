<?php

$title = 'Liste des réservations';

ob_start();
?>

    <div class="page-header">
        <div>
            <h1>Liste des réservations</h1>

            <p class="page-subtitle"> Consultez les réservations des salles universitaires. </p>
        </div>

        <a href="/reservations/create" class="btn"> Nouvelle réservation </a>
    </div>

    <?php if (empty($reservations)): ?>

    <div class="empty-state">
        <p>Aucune réservation trouvée.</p>

        <a href="/reservations/create" class="btn">
            Créer une réservation
        </a>
    </div>

    <?php else: ?>

<div class="table-wrapper">

    <table class="data-table">

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
                    <?= htmlspecialchars(
                        $reservation->salle?->nom ?? 'Salle inconnue',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $reservation->responsable,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $reservation->email,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $reservation->motif,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $reservation->date_debut->format('d/m/Y H:i'),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $reservation->date_fin->format('d/m/Y H:i'),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>

                    <?php if ($reservation->statut === 'confirmée'): ?>

                        <span class="badge badge-success">
                            Confirmée
                        </span>

                    <?php else: ?>

                        <span class="badge badge-danger">
                            Annulée
                        </span>

                    <?php endif; ?>

                </td>

                <td>
                    <a href="/reservations/<?= (int) $reservation->id ?>" class="link-action">
                        Voir
                    </a>
                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>


<?php endif; ?>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
?>
