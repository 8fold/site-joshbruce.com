<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// die(var_dump($_SERVER['CONTENT_UP']));

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

// -> 500 server code dotenv required variables not set
$envHasRequired = array_key_exists('CONTENT_UP', $_SERVER) and
    array_key_exists('CONTENT_FOLDER', $_SERVER);

if (! $envHasRequired) {
    header(
        'HTTP/2 500 Internal server error',
        replace: true,
        response_code: 500
    );
    header('Cache-Control: no-cache, must-revalidate');
    // dont' need text/hemlt header, default seems fine

    print <<<html
        <!doctype html>
        <html>
            <head>
                <title>Server error | Josh Bruce's personal site</title>
            </head>
            <body>
                <h1>500: Internal server error (environment)</h1>
                <p>We're not sure what happened here. Please try again later.</p>
                <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
            </body>
        </html>
    html;

    exit;
}

// -> 500 server code no content connection possible
$contentRoot = __DIR__ . '/content-dir';

$contentExists = file_exists($contentRoot) and is_dir($contentRoot);

if (! $contentExists) {
    header(
        'HTTP/2 500 Internal server error',
        replace: true,
        response_code: 500
    );
    header('Cache-Control: no-cache, must-revalidate');
    // dont' need text/hemlt header, default seems fine

    print <<<html
        <!doctype html>
        <html>
            <head>
                <title>Server error | Josh Bruce's personal site</title>
            </head>
            <body>
                <h1>500: Internal server error (content)</h1>
                <p>We're not sure what happened here. Please try again later.</p>
                <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
            </body>
        </html>
    html;

    exit;
}
