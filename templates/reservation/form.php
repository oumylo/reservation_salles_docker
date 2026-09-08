<?php

$title = $title ?? 'Nouvelle réservation';

$data = $data ?? [];
$errors = $errors ?? [];
$salles = $salles ?? [];

$action = $action ?? '/reservations';

$salleId = $data['salle_id'] ?? '';
$responsable = $data['responsable'] ?? '';
$email = $data['email'] ?? '';
$motif = $data['motif'] ?? '';
$dateDebut = $data['date_debut'] ?? '';
$dateFin = $data['date_fin'] ?? '';

ob_start();
?>

<div class="page-header">
    <h1><?= htmlspecialchars($title) ?></h1>
</div>

<div class="form-card">

    <form method="POST" action="<?= htmlspecialchars($action) ?>">

        <div class="form-group">
            <label for="salle_id">Salle :</label>

            <select id="salle_id" name="salle_id">
                <option value="">Sélectionner une salle</option>

                <?php foreach ($salles as $salle): ?>
                    <option
                        value="<?= (int) $salle->id ?>"
                        <?= (string) $salleId === (string) $salle->id ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($salle->nom) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php if (isset($errors['salle_id'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['salle_id']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="responsable">Responsable :</label>

            <input
                type="text"
                id="responsable"
                name="responsable"
                value="<?= htmlspecialchars((string) $responsable) ?>"
            >

            <?php if (isset($errors['responsable'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['responsable']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars((string) $email) ?>"
            >

            <?php if (isset($errors['email'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['email']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="motif">Motif :</label>

            <textarea
                id="motif"
                name="motif"
            ><?= htmlspecialchars((string) $motif) ?></textarea>

            <?php if (isset($errors['motif'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($errors['motif']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="form-row">

            <div class="form-group">
                <label for="date_debut">Date de début :</label>

                <input
                    type="datetime-local"
                    id="date_debut"
                    name="date_debut"
                    value="<?= htmlspecialchars((string) $dateDebut) ?>"
                >

                <?php if (isset($errors['date_debut'])): ?>
                    <p class="form-error">
                        <?= htmlspecialchars($errors['date_debut']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="date_fin">Date de fin :</label>

                <input
                    type="datetime-local"
                    id="date_fin"
                    name="date_fin"
                    value="<?= htmlspecialchars((string) $dateFin) ?>"
                >

                <?php if (isset($errors['date_fin'])): ?>
                    <p class="form-error">
                        <?= htmlspecialchars($errors['date_fin']) ?>
                    </p>
                <?php endif; ?>
            </div>

        </div>

        <div class="form-actions">

            <button type="submit" class="btn">
                Enregistrer la réservation
            </button>

            <a
                href="/reservations"
                class="btn btn-secondary"
            >
                Annuler
            </a>

        </div>

    </form>

</div>

<?php

$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
