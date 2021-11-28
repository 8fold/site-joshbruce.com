<?php

declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

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
            __DIR__,
            'https://joshbruce.com',
            'production'
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
