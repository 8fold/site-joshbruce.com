<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$server = JoshBruce\Site\Server::init($_SERVER);

/**
 * We'll probably replace with the middleware pattern from PSR-7.
 *
 * 1. Check .env file has the required members; 500 response on failure.
 * 2. Check the content folder can be accessed; 502 response on failure.
 * 3. Start the app and determine response.
 */
$response = $server->response();
if ($response->isOk() and $env = JoshBruce\Site\Environment::init($server)) {
    // server global set up correctly - start environment
    $response = $env->response();
    if ($response->isOk() and $app = JoshBruce\Site\App::init($env)) {
        // environment can connect to content - start app
        $response = $app->response();
    }
}
JoshBruce\Site\Emitter::emit($response);

exit;
