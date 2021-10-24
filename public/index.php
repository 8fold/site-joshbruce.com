<?php

declare(strict_types=1);

// -> 500 server code
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
                <h1>500: Internal server error</h1>
                <p>We're not sure what happened here. Please try again later.</p>
                <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
            </body>
        </html>
    html;
}
