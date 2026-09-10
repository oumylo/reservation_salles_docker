<?php

$title = 'Connexion';

ob_start();
?>

<style>

    .login-page {
        min-height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background-color: #ffffff;
        padding: 32px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .login-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .login-header h1 {
        margin-bottom: 8px;
        font-size: 28px;
        color: #1f2937;
    }

    .login-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: #374151;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .error-message {
        margin-bottom: 20px;
        padding: 12px 14px;
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 6px;
        color: #991b1b;
        font-size: 14px;
    }

    .field-error {
        margin: 6px 0 0;
        color: #dc2626;
        font-size: 13px;
    }

    .login-button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background-color: #2563eb;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .login-button:hover {
        background-color: #1d4ed8;
    }

</style>

<div class="login-page">

<div class="login-card">

    <div class="login-header">

        <h1>Connexion</h1>

        <p>
            Connectez-vous à votre espace de gestion.
        </p>

    </div>

    <?php if (!empty($errors['authentification'])): ?>

        <div class="error-message">
            <?= htmlspecialchars($errors['authentification']) ?>
        </div>

    <?php endif; ?>

    <form method="POST" action="/login">

        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                placeholder="exemple@email.com"
            >

            <?php if (!empty($errors['email'])): ?>

                <?php foreach ($errors['email'] as $error): ?>

                    <p class="field-error">
                        <?= htmlspecialchars($error) ?>
                    </p>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

        <div class="form-group">

            <label for="password">
                Mot de passe
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Votre mot de passe"
            >

            <?php if (!empty($errors['password'])): ?>

                <?php foreach ($errors['password'] as $error): ?>

                    <p class="field-error">
                        <?= htmlspecialchars($error) ?>
                    </p>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

        <button
            type="submit"
            class="login-button"
        >
            Se connecter
        </button>

    </form>

</div>


</div>

<?php

$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
?>
