    <?php

    $title = 'Détail de la salle';

    ob_start();
    ?>

    <div class="page-header">
        <div>
            <h1>Détail de la salle</h1>
        <p class="page-subtitle">
            Informations concernant cette salle.
        </p>
    </div>

    </div>

    <ul class="detail-list">

    <li>
        <strong>Nom :</strong>

        <span>
            <?= htmlspecialchars(
                $salle->nom,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </span>
    </li>

    <li>
        <strong>Bâtiment :</strong>

        <span>
            <?= htmlspecialchars(
                $salle->batiment,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </span>
    </li>

    <li>
        <strong>Capacité :</strong>

        <span>
            <?= (int) $salle->capacite ?> personnes
        </span>
    </li>

    <li>
        <strong>Type :</strong>

        <span>
            <?= htmlspecialchars( $salle->type, ENT_QUOTES, 'UTF-8' ) ?>
        </span>
    </li>

    <li>
        <strong>État :</strong>
        <span>
            <?php if ($salle->active): ?>
                <span class="badge badge-active"> Active </span>
            <?php else: ?>
                <span class="badge badge-inactive"> Inactive </span>
            <?php endif; ?>
        </span>
    </li>
    </ul>

<div class="detail-actions">
    <a href="/salles" class="btn btn-secondary"> Retour à la liste </a>
</div>

    <?php
    $content = ob_get_clean();

    require dirname(__DIR__) . '/layout/base.php';
    ?>
