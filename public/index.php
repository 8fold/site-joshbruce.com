<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

JoshBruce\Site\App::emitResponse($_SERVER);

exit;
