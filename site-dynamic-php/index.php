<?php

declare(strict_types=1);

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

require $projectRoot . '/vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable($projectRoot)->load();

JoshBruce\Site\SiteDynamic\Emitter::emit(
    response:JoshBruce\Site\HttpResponse::from(
        request: JoshBruce\Site\HttpRequest::fromGlobals()
    )
);
exit;
