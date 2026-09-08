<?php

$title = $title ?? 'Nouvelle réservation';

$data = $data ?? [];
$errors = $errors ?? [];
$salles = $salles ?? [];

$salleId = $data['salle_id'] ?? '';
$responsable = $data['responsable'] ?? '';
$email = $data['email'] ?? '';
$motif = $data['motif'] ?? '';
$dateDebut = $data['date_debut'] ?? '';
$dateFin = $data['date_fin'] ?? '';

ob_start();
?>

<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST">

    <div>
        <label for="salle_id">
            Salle :
        </label>

        <select id="salle_id" name="salle_id">

            <option value="">
                -- Sélectionner une salle --
            </option>

            <?php foreach ($salles as $salle): ?>

                <option
                    value="<?= (int) $salle->id ?>"
                    <?= (string) $salleId === (string) $salle->id ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars(
                        $salle->nom
                    ) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($errors['salle_id'])): ?>
            <p>
                <?= htmlspecialchars(
                    $errors['salle_id']
                ) ?>
            </p>
        <?php endif; ?>
    </div>


    <div>
        <label for="responsable">
            Responsable :
        </label>

        <input
            type="text"
            id="responsable"
            name="responsable"
            value="<?= htmlspecialchars(
                (string) $responsable
            ) ?>"
        >

        <?php if (isset($errors['responsable'])): ?>
            <p>
                <?= htmlspecialchars(
                    $errors['responsable']
                ) ?>
            </p>
        <?php endif; ?>
    </div>


    <div>
        <label for="email">
            Email :
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars(
                (string) $email
            ) ?>"
        >

        <?php if (isset($errors['email'])): ?>
            <p>
                <?= htmlspecialchars(
                    $errors['email']
                ) ?>
            </p>
        <?php endif; ?>
    </div>


    <div>
        <label for="motif">
            Motif :
        </label>

        <textarea
            id="motif"
            name="motif"
        ><?= htmlspecialchars(
            (string) $motif
        ) ?></textarea>

        <?php if (isset($errors['motif'])): ?>
            <p>
                <?= htmlspecialchars(
                    $errors['motif']
                ) ?>
            </p>
        <?php endif; ?>
    </div>


    <div>
        <label for="date_debut">
            Date de début :
        </label>

        <input
            type="datetime-local"
            id="date_debut"
            name="date_debut"
            value="<?= htmlspecialchars(
                (string) $dateDebut
            ) ?>"
        >

        <?php if (isset($errors['date_debut'])): ?>
            <p>
                <?= htmlspecialchars(
                    $errors['date_debut']
                ) ?>
            </p>
        <?php endif; ?>
    </div>


    <div>
        <label for="date_fin">
            Date de fin :
        </label>

        <input
            type="datetime-local"
            id="date_fin"
            name="date_fin"
            value="<?= htmlspecialchars(
                (string) $dateFin) ?>">

        <?php if (isset($errors['date_fin'])): ?>
            <p>
                <?= htmlspecialchars( $errors['date_fin'] ) ?>
            </p>
        <?php endif; ?>
    </div>


    <div>
        <button type="submit">
            Enregistrer la réservation
        </button>

        <a href="/reservations">
            Annuler
        </a>
    </div>

</form>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';