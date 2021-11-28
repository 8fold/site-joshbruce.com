<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require __DIR__ . '/../../vendor/autoload.php';

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Http\Emitter;
use JoshBruce\SiteDynamic\Http\RequestHandler;

use JoshBruce\SiteDynamic\FileSystem\Finder;

use JoshBruce\SiteDynamic\Environment;

Emitter::emit(
    RequestHandler::in(
        Environment::with(
            __DIR__ . '/../../content/public',
            'http://com.joshbruce-dynamic:8889',
            'local'
        )
    )->handle(
        new ServerRequest(
            method: $_SERVER['REQUEST_METHOD'],
            uri: $_SERVER['REQUEST_URI'],
            headers: getallheaders(),
            serverParams: $_SERVER
        )
    )
);
exit;
