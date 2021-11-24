<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

require $projectRoot . '/vendor/autoload.php';

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Http\Emitter;
use JoshBruce\SiteDynamic\Http\RequestHandler;
use JoshBruce\SiteDynamic\Http\Request;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\Finder;

Emitter::emit(
    RequestHandler::in(
        Finder::init(),
        Environment::with($projectRoot)
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
