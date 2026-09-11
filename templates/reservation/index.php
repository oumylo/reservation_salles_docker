<?php

$title = 'Liste des réservations';

?>

<style>
    /* =========================
       En-tête
       ========================= */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-title {
        margin: 0 0 8px;
        font-size: 30px;
        font-weight: 700;
        color: #111827;
    }

    .page-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }

    .page-actions {
        flex-shrink: 0;
    }

    /* =========================
       Boutons
       ========================= */

    .btn {
        display: inline-block;
        padding: 11px 18px;
        background-color: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.2s, transform 0.1s;
    }

    .btn:hover {
        background-color: #1d4ed8;
    }

    .btn:active {
        transform: translateY(1px);
    }

    /* =========================
       État vide
       ========================= */

    .empty-state {
        padding: 55px 25px;
        text-align: center;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .empty-state p {
        margin: 0 0 20px;
        color: #6b7280;
        font-size: 15px;
    }

    /* =========================
       Tableau
       ========================= */

    .table-container {
        width: 100%;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    .data-table thead {
        background-color: #f8fafc;
    }

    .data-table th {
        padding: 15px 16px;
        text-align: left;
        color: #374151;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .data-table td {
        padding: 16px;
        color: #4b5563;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: background-color 0.2s;
    }

    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* =========================
       Salle
       ========================= */

    .data-table td:first-child {
        color: #111827;
        font-weight: 600;
    }

    /* =========================
       Motif
       ========================= */

    .data-table td:nth-child(4) {
        max-width: 250px;
    }

    /* =========================
       Dates
       ========================= */

    .data-table td:nth-child(5),
    .data-table td:nth-child(6) {
        white-space: nowrap;
        color: #374151;
    }

    /* =========================
       Badges
       ========================= */

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background-color: #dcfce7;
        color: #15803d;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* =========================
       Actions
       ========================= */

    .data-table td:last-child {
        white-space: nowrap;
    }

    .link-action {
        display: inline-block;
        padding: 0;
        border: none;
        background: none;
        color: #2563eb;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .link-action:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .data-table td:last-child form {
        display: inline;
        margin-left: 12px;
    }

    .data-table td:last-child form .link-action {
        color: #dc2626;
    }

    .data-table td:last-child form .link-action:hover {
        color: #b91c1c;
    }

    /* =========================
       Pagination
       ========================= */

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-width: 38px;
        height: 38px;
        padding: 0 11px;
        box-sizing: border-box;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .pagination a {
        color: #2563eb;
        background-color: white;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .pagination a:hover {
        background-color: #eff6ff;
        border-color: #bfdbfe;
    }

    .pagination .current {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .pagination .disabled {
        color: #9ca3af;
        background-color: #f9fafb;
        cursor: not-allowed;
    }

    /* =========================
       Responsive
       ========================= */

    @media (max-width: 700px) {

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 25px;
        }

        .page-actions {
            width: 100%;
        }

        .page-actions .btn {
            display: block;
            text-align: center;
        }

        .empty-state {
            padding: 40px 20px;
        }
    }
</style>

<div class="page-header">


<div class="page-header-left">

    <h1 class="page-title">Liste des réservations</h1>

    <p class="page-subtitle">
        Consultez les réservations des salles universitaires.
    </p>

</div>

<?php if ($isAdmin): ?>

    <div class="page-actions">

        <a href="/reservations/create" class="btn">
            Nouvelle réservation
        </a>

    </div>

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

<div class="table-container">

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


</div>



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


