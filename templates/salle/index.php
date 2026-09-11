<?php

$title = 'Liste des salles';

?>

<style>
    /* =========================
       En-tête de la page
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
       Tableau de bord
       ========================= */

    .statistics-section {
        margin-bottom: 35px;
    }

    .statistics-header {
        margin-bottom: 18px;
    }

    .statistics-title {
        margin: 0 0 6px;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
    }

    .statistics-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .statistics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .stat-card {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 22px;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .stat-rank {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 50%;
        background-color: #eff6ff;
        color: #2563eb;
        font-size: 15px;
        font-weight: 700;
    }

    .stat-content {
        min-width: 0;
    }

    .stat-content h3 {
        margin: 0 0 5px;
        color: #111827;
        font-size: 17px;
        font-weight: 700;
    }

    .stat-building {
        margin: 0 0 15px;
        color: #6b7280;
        font-size: 13px;
    }

    .stat-number {
        color: #2563eb;
        font-size: 27px;
        font-weight: 700;
        line-height: 1;
    }

    .stat-label {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 12px;
    }

    /* =========================
       Message d'erreur
       ========================= */

    .alert {
        padding: 14px 16px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .alert-error {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    /* =========================
       État vide
       ========================= */

    .empty-state {
        padding: 50px 20px;
        text-align: center;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        color: #6b7280;
    }

    .empty-state p {
        margin: 0;
        font-size: 15px;
    }

    /* =========================
       Tableau
       ========================= */

    .table-container {
        width: 100%;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .data-table thead {
        background-color: #f3f4f6;
    }

    .data-table th {
        padding: 14px 16px;
        text-align: left;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .data-table td {
        padding: 15px 16px;
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
       Badge Active / Inactive
       ========================= */

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-active {
        background-color: #dcfce7;
        color: #15803d;
    }

    .badge-inactive {
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
        color: #2563eb;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .link-action:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .link-action-danger {
        color: #dc2626;
    }

    .link-action-danger:hover {
        color: #b91c1c;
    }

    .actions-separator {
        margin: 0 7px;
        color: #d1d5db;
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
        padding: 0 10px;
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
        transition: background-color 0.2s;
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

    @media (max-width: 900px) {

        .statistics-grid {
            grid-template-columns: 1fr;
        }
    }

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

        .table-container {
            border-radius: 8px;
        }
    }
</style>

<!-- =========================
     En-tête
     ========================= -->

<div class="page-header">

<div class="page-header-left">

    <h1 class="page-title">
        Liste des salles
    </h1>

    <p class="page-subtitle">
        Retrouvez et gérez les espaces disponibles.
    </p>

</div>


<?php if ($isAdmin): ?>

    <div class="page-actions">

        <a href="/salles/create" class="btn">
            Enregistrer une salle
        </a>

    </div>

<?php endif; ?>

</div>

<!-- =========================
     Tableau de bord
     ========================= -->

<?php if (!empty($sallesLesPlusUtilisees)): ?>

<section class="statistics-section">



    <div class="statistics-grid">

        <?php foreach (
            array_slice($sallesLesPlusUtilisees, 0, 3)
            as $index => $salle
        ): ?>

            <div class="stat-card">

                <div class="stat-rank">
                    <?= $index + 1 ?>
                </div>


                <div class="stat-content">

                    <h3>
                        <?= htmlspecialchars(
                            $salle['nom'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h3>


                    <p class="stat-building">
                        <?= htmlspecialchars(
                            $salle['batiment'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>


                    <div class="stat-number">
                        <?= (int) $salle['nombre_reservations'] ?>
                    </div>


                    <p class="stat-label">
                        réservation<?= (
                            (int) $salle['nombre_reservations'] > 1
                        ) ? 's' : '' ?>
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>


<?php endif; ?>

<?php if (!empty($messageErreur)): ?>


<div class="alert alert-error">

    <?= htmlspecialchars($messageErreur) ?>

</div>

<?php endif; ?>


<?php if ($salles->isEmpty()): ?>


<div class="empty-state">

    <p>
        Aucune salle disponible.
    </p>

</div>


<?php else: ?>

<div class="table-container">

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>
                    
                    <th>Nom</th>
                    <th>Bâtiment</th>
                    <th>Capacité</th>
                    <th>Type</th>
                    <th>Active</th>
                    <th>Actions</th>
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
                        <?= htmlspecialchars($salle->capacite) ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($salle->type) ?>
                    </td>


                    <td>

                        <?php if ($salle->active): ?>

                            <span class="badge badge-active">
                                Oui
                            </span>

                        <?php else: ?>

                            <span class="badge badge-inactive">
                                Non
                            </span>

                        <?php endif; ?>

                    </td>


                    <td>

                        <a
                            href="/salles/<?= $salle->id ?>"
                            class="link-action"
                        >
                            Voir
                        </a>


                        <?php if ($isAdmin): ?>

                            <span class="actions-separator">
                                |
                            </span>


                            <a
                                href="/salles/<?= $salle->id ?>/edit"
                                class="link-action"
                            >
                                Modifier
                            </a>


                            <span class="actions-separator">
                                |
                            </span>


                            <form
                                method="POST"
                                action="/salles/<?= $salle->id ?>/delete"
                                style="display: inline;"
                            >

                                <button
                                    type="submit"
                                    class="link-action link-action-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?');"
                                >
                                    Supprimer
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


<!-- =========================
     Pagination
     ========================= -->

<?php if ($salles->lastPage() > 1): ?>

    <div class="pagination">

        <?php if ($salles->onFirstPage()): ?>

            <span class="disabled">
                Précédent
            </span>

        <?php else: ?>

            <a href="<?= htmlspecialchars(
                $salles->previousPageUrl()
            ) ?>">
                Précédent
            </a>

        <?php endif; ?>


        <?php for (
            $page = 1;
            $page <= $salles->lastPage();
            $page++
        ): ?>

            <?php if ($page === $salles->currentPage()): ?>

                <span class="current">
                    <?= $page ?>
                </span>

            <?php else: ?>

                <a href="<?= htmlspecialchars(
                    $salles->url($page)
                ) ?>">
                    <?= $page ?>
                </a>

            <?php endif; ?>

        <?php endfor; ?>


        <?php if ($salles->hasMorePages()): ?>

            <a href="<?= htmlspecialchars(
                $salles->nextPageUrl()
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
