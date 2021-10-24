<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use JoshBruce\Site\Emitter;

function emitErrorHeaders(int $code): void {
    if ($code === 500) {
        Emitter::create($code, 'Iternal server error')->emitStatusLine();
        // emitStatusLine($code, );
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

// -> 404 server code no valid content
$contentRoot    = $contentRoot;
$requestUri     = $_SERVER['REQUEST_URI'];
$requestAbspath = $contentRoot . $requestUri . '/content.md';

$contentExists = file_exists($requestAbspath) and is_file($requestAbspath);

if (! $contentExists) {
    Emitter::create(404, 'Not found')->emitStatusLine();
    // emitStatusLine(404, 'Not found');
    header('Cache-Control: no-cache, must-revalidate');
    print <<<html
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
        html;

    exit;
}

Emitter::create(200, 'Ok')->emitStatusLine();
// emitStatusLine(200, 'Ok');
header('Cache-Control: max-age=600');

print <<<html
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
    html;

exit;
