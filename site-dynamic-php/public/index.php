<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

require $projectRoot . '/vendor/autoload.php';

use Dotenv\Dotenv;

use JoshBruce\SiteDynamic\Http\Emitter;
// use JoshBruce\SiteDynamic\Http\Response;
use JoshBruce\SiteDynamic\Http\RequestHandler;
use JoshBruce\SiteDynamic\Http\Request;

use JoshBruce\SiteDynamic\FileSystem\Finder;

Dotenv::createImmutable($projectRoot)->load(); // modify $_SERVER superglobals

Emitter::emit(
    RequestHandler::in(
        Finder::init()
    )->handle(
        Request::fromGlobals()
    )
);
exit;
