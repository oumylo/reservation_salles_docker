<?php

$title = $title ?? 'Ajouter une salle';

$data = $data ?? [];
$errors = $errors ?? [];
$salle = $salle ?? null;

$nom = $data['nom'] ?? '';
$batiment = $data['batiment'] ?? '';
$capacite = $data['capacite'] ?? '';
$type = $data['type'] ?? '';
$active = $data['active'] ?? true;

$formAction = $salle !== null ? '/salles/' . (int) $salle->id . '/edit' : '/salles';

?>

<div class="page-header">

    <div class="page-header-left">

        <h1 class="page-title"><?= htmlspecialchars($title) ?></h1>

        <p class="page-subtitle">
            Renseignez les informations principales de la salle.
        </p>

    </div>

</div>

<div class="form-card">
    <form method="POST" action="<?= htmlspecialchars($formAction) ?>">

        <div class="form-group">
            <label for="nom">Nom :</label>

            <input
                type="text"
                id="nom"
                name="nom"
                value="<?= htmlspecialchars((string) $nom) ?>"
            >

            <?php if (isset($errors['nom'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['nom']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="batiment">Bâtiment :</label>

            <input
                type="text"
                id="batiment"
                name="batiment"
                value="<?= htmlspecialchars((string) $batiment) ?>"
            >

            <?php if (isset($errors['batiment'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['batiment']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="capacite">Capacité :</label>

            <input
                type="number"
                id="capacite"
                name="capacite"
                value="<?= htmlspecialchars((string) $capacite) ?>"
            >

            <?php if (isset($errors['capacite'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['capacite']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="type">Type :</label>

            <select id="type" name="type">

                <option value="">-- Sélectionner --</option>

                <option value="cours" <?= $type === 'cours' ? 'selected' : '' ?>>
                    Cours
                </option>

                <option value="informatique" <?= $type === 'informatique' ? 'selected' : '' ?>>
                    Informatique
                </option>

                <option value="laboratoire" <?= $type === 'laboratoire' ? 'selected' : '' ?>>
                    Laboratoire
                </option>

                <option value="amphitheatre" <?= $type === 'amphitheatre' ? 'selected' : '' ?>>
                    Amphithéâtre
                </option>

                <option value="reunion" <?= $type === 'reunion' ? 'selected' : '' ?>>
                    Réunion
                </option>

            </select>

            <?php if (isset($errors['type'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['type']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-checkbox">
                <input
                    type="checkbox"
                    name="active"
                    value="1"
                    <?= $active ? 'checked' : '' ?>
                >

                Salle active
            </label>

            <?php if (isset($errors['active'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['active']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                Enregistrer
            </button>

            <a href="/salles" class="btn btn-secondary">
                Annuler
            </a>
        </div>

    </form>
</div>

