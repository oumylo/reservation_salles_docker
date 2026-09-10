<?php

$title = 'Liste des réservations';

ob_start();

?>

<div class="page-header">

    <div>

        <h1>Liste des réservations</h1>

        <p class="page-subtitle">
            Consultez les réservations des salles universitaires.
        </p>

    </div>


    <?php if ($isAdmin): ?>

        <a href="/reservations/create" class="btn">
            Nouvelle réservation
        </a>

    <?php endif; ?>

</div>


<?php if ($reservations->isEmpty()): ?>

    <div class="empty-state">

        <p>
            Aucune réservation trouvée.
        </p>


        <?php if ($isAdmin): ?>

            <a href="/reservations/create" class="btn">
                Créer une réservation
            </a>

        <?php endif; ?>

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

                    <a
                        href="/reservations/<?= (int) $reservation->id ?>"
                        class="link-action"
                    >
                        Voir
                    </a>


                    <?php if ($isAdmin && $reservation->statut === 'confirmée'): ?>

                        <form
                            method="POST"
                            action="/reservations/<?= (int) $reservation->id ?>/cancel"
                            style="display: inline;"
                        >

                            <button
                                type="submit"
                                class="link-action"
                            >
                                Annuler
                            </button>

                        </form>

                    <?php endif; ?>

                </td>

            </tr>


        <?php endforeach; ?>


        </tbody>

    </table>

</div>


<!-- Pagination -->

<?php if ($reservations->lastPage() > 1): ?>

    <div class="pagination">


        <?php if ($reservations->onFirstPage()): ?>

            <span class="disabled">
                Précédent
            </span>

        <?php else: ?>

            <a href="<?= htmlspecialchars(
                $reservations->previousPageUrl(),
                ENT_QUOTES,
                'UTF-8'
            ) ?>">
                Précédent
            </a>

        <?php endif; ?>


        <?php for (
            $page = 1;
            $page <= $reservations->lastPage();
            $page++
        ): ?>


            <?php if ($page === $reservations->currentPage()): ?>

                <span class="current">
                    <?= $page ?>
                </span>

            <?php else: ?>

                <a href="<?= htmlspecialchars(
                    $reservations->url($page),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>">
                    <?= $page ?>
                </a>

            <?php endif; ?>


        <?php endfor; ?>


        <?php if ($reservations->hasMorePages()): ?>

            <a href="<?= htmlspecialchars(
                $reservations->nextPageUrl(),
                ENT_QUOTES,
                'UTF-8'
            ) ?>">
                Suivant
            </a>

        <?php else: ?>

            <span class="disabled">
                Suivant
            </span>

        <?php endif; ?>


    </div>

<?php endif; ?>


<?php endif; ?>


<?php

$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
?>
