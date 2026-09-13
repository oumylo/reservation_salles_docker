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
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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

    .login-footer {
        margin-top: 22px;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
    }

    .login-footer a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    /* ==============================
       COMPTES DE DÉMONSTRATION
       ============================== */

    .demo-section {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e5e7eb;
    }

    .demo-header {
        text-align: center;
        margin-bottom: 16px;
    }

    .demo-header h2 {
        margin: 0 0 6px;
        color: #111827;
        font-size: 17px;
        font-weight: 700;
    }

    .demo-header p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
    }

    .demo-account {
        position: relative;
        padding: 15px 16px;
        margin-top: 10px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
    }

    .demo-account:hover {
        border-color: #bfdbfe;
        background-color: #f8fbff;
    }

    .demo-account-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 11px;
        color: #1e293b;
        font-size: 14px;
        font-weight: 700;
    }

    .demo-account-title .icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #dbeafe;
        border-radius: 7px;
        font-size: 15px;
    }

    .demo-account-info {
        display: grid;
        grid-template-columns: 90px 1fr;
        gap: 6px;
        margin: 0;
        font-size: 13px;
    }

    .demo-account-info dt {
        color: #64748b;
        font-weight: 600;
    }

    .demo-account-info dd {
        margin: 0;
        color: #334155;
        word-break: break-word;
    }

    .demo-password {
        font-family: monospace;
        background-color: #eef2ff;
        padding: 2px 6px;
        border-radius: 4px;
        color: #3730a3;
    }

    .demo-note {
        margin: 14px 0 0;
        text-align: center;
        color: #94a3b8;
        font-size: 11px;
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

        .demo-account-info {
            grid-template-columns: 75px 1fr;
        }
    }
</style>

<div class="login-page">

```
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


        <div class="login-footer">

            Pas encore de compte ?

            <a href="/register">
                S'inscrire
            </a>

        </div>

    </form>


    <!--
        Comptes de démonstration destinés au professeur.
        Ces comptes permettent de tester rapidement
        les différents rôles de l'application.
    -->

    <div class="demo-section">

        <div class="demo-header">

            <h2>Comptes de démonstration</h2>

            <p>
                Utilisez l'un de ces comptes pour tester l'application.
            </p>

        </div>


        <div class="demo-account">

            <div class="demo-account-title">

                <div class="icon">
                    👑
                </div>

                Administrateur

            </div>


            <dl class="demo-account-info">

                <dt>Email</dt>

                <dd>
                    admin@example.com
                </dd>


                <dt>Mot de passe</dt>

                <dd>
                    <span class="demo-password">
                        admin123
                    </span>
                </dd>

            </dl>

        </div>


        <div class="demo-account">

            <div class="demo-account-title">

                <div class="icon">
                    👤
                </div>

                Responsable

            </div>


            <dl class="demo-account-info">

                <dt>Email</dt>

                <dd>
                    responsable@example.com
                </dd>


                <dt>Mot de passe</dt>

                <dd>
                    <span class="demo-password">
                        responsable123
                    </span>
                </dd>

            </dl>

        </div>


        <p class="demo-note">
            Comptes fournis uniquement pour la démonstration du projet.
        </p>

    </div>

</div>


</div>
