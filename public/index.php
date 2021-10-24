<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

function emitErrorHeaders(int $code): void {
    if ($code === 500) {
        header(
            'HTTP/2 500 Internal server error',
            replace: true,
            response_code: 500
        );
        header('Cache-Control: no-cache, must-revalidate');
        // dont' need text/hemlt header, default seems fine

    }
}

function emitErrorBody(int $code, string $details): void {
    print <<<html
        <!doctype html>
        <html>
            <head>
                <title>Server error | Josh Bruce's personal site</title>
            </head>
            <body>
                <h1>$code: Internal server error ($details)</h1>
                <p>We're not sure what happened here. Please try again later.</p>
                <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
            </body>
        </html>
    html;

    exit;
}

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

// -> 500 server code dotenv required variables not set
$envHasRequired = array_key_exists('CONTENT_UP', $_SERVER) and
    array_key_exists('CONTENT_FOLDER', $_SERVER);

if (! $envHasRequired) {
    emitErrorHeaders(500);
    emitErrorBody(500, 'environment');
}

// -> 500 server code no content connection possible
$contentUp      = $_SERVER['CONTENT_UP'];
$contentFolder  = $_SERVER['CONTENT_FOLDER'];
$contentStart   = __DIR__;
$contentParts   = explode('/', $contentStart);
$contentParts   = array_slice($contentParts, 0, -1 * $contentUp);
$contentParts[] = $contentFolder;
$contentRoot    = implode('/', $contentParts);

$contentExists = file_exists($contentRoot) and is_dir($contentRoot);

if (! $contentExists) {
    emitErrorHeaders(500);
    emitErrorBody(500, 'content');
}
