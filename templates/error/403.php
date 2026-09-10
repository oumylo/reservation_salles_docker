<?php

$title = 'Accès interdit';

ob_start();
?>

<h1>Accès interdit</h1>

<p>
    Vous n'avez pas les droits nécessaires pour effectuer cette action.
</p>

<p>
    <a href="/salles">Retour aux salles</a>
</p>

<?php
$content = ob_get_clean();

require dirname(__DIR__) . '/layout/base.php';

