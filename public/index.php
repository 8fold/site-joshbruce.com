<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

use JoshBruce\Site\Environment;
use JoshBruce\Site\Emitter;
use JoshBruce\Site\Http\Response;

// Inject environment variables to global $_SERVER array
Dotenv::createImmutable(__DIR__ . '/../')->load();

// Verify environment has minimal structure
$env = Environment::init($_SERVER);
if ($env->isNotVerified()) {
    Emitter::emit($env->response());
}

// -> 404 server code no valid content
$contentRoot     = $env->contentRoot();
$requestParts    = explode('/', $contentRoot);
$requestUriParts = explode('/', $_SERVER['REQUEST_URI']);
$parts           = array_merge($requestParts, $requestUriParts);
$parts[]         = 'content.md';
$parts           = array_filter($parts);
$requestAbspath  = '/' . implode('/', $parts);
$contentExists   = file_exists($requestAbspath) and is_file($requestAbspath);

$response = Response::create(
    200,
    headers: [
        'Cache-Control' => ['max-age=600']
    ],
    body: <<<html
        <!doctype html>
        <html>
            <head>
                <title>Josh Bruce's personal site</title>
                <style>
                    h1 {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <h1>The domain of Josh Bruce</h1>
                <p>This content was successfully found.</p>
            </body>
        </html>
        html,
    reason: 'Ok'
);

if (! $contentExists) {
    $response = Response::create(
        404,
        headers: [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        body: <<<html
            <!doctype html>
            <html>
                <head>
                    <title>Not found | Josh Bruce's personal site</title>
                    <style>
                        h1 {
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <h1>404: Not found</h1>
                    <p>We still haven't found what you're looking for.</p>
                </body>
            </html>
            html,
        reason: 'Not found'
    );
}

Emitter::emit($response);

exit;
