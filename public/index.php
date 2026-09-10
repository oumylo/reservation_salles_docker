<?php

declare(strict_types=1);

use App\Application;

$application = require dirname(__DIR__) . '/bootstrap.php';

$application->run();