<?php

$title = 'Connexion';

?>

<style>
    .login-page {
        min-height: 75vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .login-brand {
        width: 64px;
        height: 64px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #2563eb;
        color: white;
        font-size: 22px;
        font-weight: bold;
        border-radius: 50%;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header h1 {
        margin: 0 0 10px;
        color: #111827;
        font-size: 28px;
    }

    .login-header p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-size: 15px;
        background-color: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .form-group input::placeholder {
        color: #9ca3af;
    }

    .login-button {
        width: 100%;
        padding: 13px 16px;
        border: none;
        border-radius: 7px;
        background-color: #2563eb;
        color: white;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
    }

    .login-button:hover {
        background-color: #1d4ed8;
    }

    .login-button:active {
        transform: translateY(1px);
    }

    .login-error {
        margin-bottom: 22px;
        padding: 12px 14px;
        border-radius: 7px;
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 14px;
    }

    .field-error {
        margin: 7px 0 0;
        color: #dc2626;
        font-size: 13px;
    }

    @media (max-width: 500px) {
        .login-page {
            padding: 25px 15px;
        }

        .login-card {
            padding: 30px 22px;
        }

        .login-header h1 {
            font-size: 24px;
        }
    }
</style>


<div class="login-page">

    <div class="login-card">

        <div class="login-brand" aria-hidden="true">
            GS
        </div>

        <div class="login-header">

            <h1>Connexion</h1>

            <p>
                Connectez-vous à votre espace de gestion.
            </p>

        </div>


        <?php if (!empty($errors['authentification'])): ?>

            <div class="login-error">

                <?= htmlspecialchars(
                    $errors['authentification']
                ) ?>

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
                    value="<?= htmlspecialchars(
                        $data['email'] ?? ''
                    ) ?>"
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



