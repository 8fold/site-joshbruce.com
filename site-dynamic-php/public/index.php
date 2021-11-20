<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

require $projectRoot . '/vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable($projectRoot)->load();

JoshBruce\Site\SiteDynamic\Emitter::emit(
    response:JoshBruce\Site\HttpResponse::from(
        request: JoshBruce\Site\HttpRequest::with(
            JoshBruce\Site\ServerGlobals::init(),
            JoshBruce\Site\FileSystem::init()
        )
    )
);
exit;
