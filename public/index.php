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
    // dont' need text/hemlt header, default seems fine

    print 'Internal server error';
}
