<?php

$title = 'Liste des salles';

ob_start();

?>

<style>

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #2563eb;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn:hover {
        background-color: #1d4ed8;
    }

    .empty-message {
        padding: 16px;
        background-color: #f3f4f6;
        border-radius: 6px;
        color: #4b5563;
    }

    .error-message {
        margin: 15px 0;
        padding: 12px 16px;
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 6px;
    }

    table.salles-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table.salles-table thead {
        background-color: #f9fafb;
    }

    table.salles-table th,
    table.salles-table td {
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        text-align: left;
    }

    table.salles-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .link-action {
        color: #2563eb;
        text-decoration: none;
        margin-right: 10px;
    }

    .link-action:hover {
        text-decoration: underline;
    }

    .btn-delete {
        border: none;
        background: none;
        padding: 0;
        color: #dc2626;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-delete:hover {
        text-decoration: underline;
    }

</style>

<div class="page-header">


<h1>Liste des salles</h1>

</div>

<p>

<a href="/salles/create" class="btn">
    Ajouter une salle
</a>

</p>

<?php if (!empty($messageErreur)): ?>

<div class="error-message">
    <?= htmlspecialchars($messageErreur) ?>
</div>


<?php endif; ?>

<?php if (empty($salles)): ?>


<p class="empty-message">
    Aucune salle disponible.
</p>


<?php else: ?>

<table class="salles-table">

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

                <span class="badge <?= $salle->active ? 'badge-active' : 'badge-inactive' ?>">

                    <?= $salle->active ? 'Active' : 'Inactive' ?>

                </span>

            </td>

            <td>

                <a
                    class="link-action"
                    href="/salles/<?= (int) $salle->id ?>"
                >
                    Voir
                </a>

                <a
                    class="link-action"
                    href="/salles/<?= (int) $salle->id ?>/edit"
                >
                    Modifier
                </a>

                <form
                    method="POST"
                    action="/salles/<?= (int) $salle->id ?>/delete"
                    style="display: inline;"
                    onsubmit="return confirm('Voulez-vous vraiment supprimer cette salle ?');"
                >

                    <button
                        type="submit"
                        class="btn-delete"
                    >
                        Supprimer
                    </button>

                </form>

            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>


<?php endif; ?>

<?php

$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
?>
