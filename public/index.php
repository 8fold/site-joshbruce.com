<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

use JoshBruce\Site\Environment;
use JoshBruce\Site\Emitter;
use JoshBruce\Site\App;
use JoshBruce\Site\Http\Response;

$response = null;

// Inject environment variables to global $_SERVER array
Dotenv::createImmutable(__DIR__ . '/../')->load();

// Verify environment has minimal structure
$env = Environment::init($_SERVER);
if ($env->isNotVerified()) {
    $response = $env->response();

} else {
    $response = App::init($env)->response();

}

Emitter::emit($response);

exit;
