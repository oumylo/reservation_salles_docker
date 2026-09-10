<?php

$title = 'Liste des salles';

ob_start();

?>

<style>
    h1 {
        margin-bottom: 20px;
    }

    .actions {
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        background-color: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        margin-right: 8px;
    }

    .btn:hover {
        background-color: #1d4ed8;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f3f4f6;
    }

    .pagination {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-top: 25px;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
    }

    .pagination a {
        color: #2563eb;
        background-color: white;
    }

    .pagination a:hover {
        background-color: #f3f4f6;
    }

    .pagination .current {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .pagination .disabled {
        color: #999;
        background-color: #f3f3f3;
    }

    .btn-danger {
        background-color: #dc2626;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
    }
</style>

<h1>Liste des salles</h1>


<?php if ($isAdmin): ?>

    <div class="actions">

        <!--
            Ce bouton permet à l'administrateur
            d'accéder au formulaire de création d'une salle.
        -->
        <a href="/salles/create" class="btn">
            Enregistrer une salle
        </a>

    </div>

<?php endif; ?>


<?php if ($salles->isEmpty()): ?>

    <p>Aucune salle disponible.</p>

<?php else: ?>

    <table>

        <thead>
            <tr>
                <th>ID</th>
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
                    <?= htmlspecialchars($salle->id) ?>
                </td>

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
                    <?= $salle->active ? 'Oui' : 'Non' ?>
                </td>

                <td>

                    <a href="/salles/<?= $salle->id ?>">
                        Voir
                    </a>

                    <?php if ($isAdmin): ?>

                        |

                        <a href="/salles/<?= $salle->id ?>/edit">
                            Modifier
                        </a>

                        |

                        <form
                            method="POST"
                            action="/salles/<?= $salle->id ?>/delete"
                            style="display: inline;"
                        >
                            <button
                                type="submit"
                                class="btn-danger"
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


    <!-- Pagination -->

    <?php if ($salles->lastPage() > 1): ?>

        <div class="pagination">

            <?php if ($salles->onFirstPage()): ?>

                <span class="disabled">
                    Précédent
                </span>

            <?php else: ?>

                <a href="<?= htmlspecialchars($salles->previousPageUrl()) ?>">
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

                    <a href="<?= htmlspecialchars($salles->url($page)) ?>">
                        <?= $page ?>
                    </a>

                <?php endif; ?>

            <?php endfor; ?>


            <?php if ($salles->hasMorePages()): ?>

                <a href="<?= htmlspecialchars($salles->nextPageUrl()) ?>">
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
