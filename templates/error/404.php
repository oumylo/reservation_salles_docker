<?php

$title = 'Page introuvable';

ob_start();
?>

<h1>404 - Page introuvable</h1>

<p>
    La page demandée n'existe pas.
</p>

<p>
    <a href="/salles">
        Retour aux salles
    </a>
</p>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';
