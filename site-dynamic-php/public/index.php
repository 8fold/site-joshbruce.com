<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

require $projectRoot . '/vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable($projectRoot)->load();

JoshBruce\SiteDynamic\Http\Emitter::emit(
    JoshBruce\SiteDynamic\Http\Response::from(
        JoshBruce\SiteDynamic\Http\Request::fromGlobals(),
        in: JoshBruce\SiteDynamic\FileSystem\Finder::init()
    )
);
exit;
