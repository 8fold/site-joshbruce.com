<?php

require __DIR__ . '/../vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

JoshBruce\Site\App::emitResponse($_SERVER);

exit;
