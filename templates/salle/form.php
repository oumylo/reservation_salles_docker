<?php

$title = $title ?? 'Ajouter une salle';

$data = $data ?? [];
$errors = $errors ?? [];

$nom = $data['nom'] ?? '';
$batiment = $data['batiment'] ?? '';
$capacite = $data['capacite'] ?? '';
$type = $data['type'] ?? '';
$active = $data['active'] ?? true;

ob_start();
?>

<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST">

    <div>
        <label for="nom">Nom :</label>

        <input
            type="text"
            id="nom"
            name="nom"
            value="<?= htmlspecialchars((string) $nom) ?>"
        >

        <?php if (isset($errors['nom'])): ?>
            <p>
                <?= htmlspecialchars($errors['nom']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div>
        <label for="batiment">Bâtiment :</label>

        <input
            type="text"
            id="batiment"
            name="batiment"
            value="<?= htmlspecialchars((string) $batiment) ?>"
        >

        <?php if (isset($errors['batiment'])): ?>
            <p>
                <?= htmlspecialchars($errors['batiment']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div>
        <label for="capacite">Capacité :</label>

        <input
            type="number"
            id="capacite"
            name="capacite"
            value="<?= htmlspecialchars((string) $capacite) ?>"
        >

        <?php if (isset($errors['capacite'])): ?>
            <p>
                <?= htmlspecialchars($errors['capacite']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div>
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
            <p>
                <?= htmlspecialchars($errors['type']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div>
        <label>
            <input
                type="checkbox"
                name="active"
                value="1"
                <?= $active ? 'checked' : '' ?>
            >

            Salle active
        </label>

        <?php if (isset($errors['active'])): ?>
            <p>
                <?= htmlspecialchars($errors['active']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div>
        <button type="submit">
            Enregistrer
        </button>

        <a href="/salles">
            Annuler
        </a>
    </div>

</form>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';