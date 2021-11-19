<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

require $projectRoot . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable($projectRoot)->load();

$globals = JoshBruce\Site\ServerGlobals::init();
$uri     = $globals->requestUri();

$fileSystem = JoshBruce\Site\FileSystem::init();
$linksPath  = $fileSystem->publicRoot() . '/links.txt';
$file       = JoshBruce\Site\File::at($linksPath, $fileSystem);
$contents   = $file->contents();
$redirects  = array_filter(explode("\n", $contents));

$destination = '';
foreach ($redirects as $redirect) {
    list($short, $dest) = explode(' ', $redirect, 2);
    if ('/' . $short === $uri) {
        $destination = "{$globals->appUrl()}{$dest}";
        break;
    }
}

if (strlen($destination) > 0) {
    $response = new Nyholm\Psr7\Response(
        302,
        [
            'Location' => $destination
        ],
        ''
    );

    $emitter = new Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter();
    $emitter->emit($response);
    exit;
}

$response = new Nyholm\Psr7\Response(
    404,
    [],
    JoshBruce\Site\File::at(
        __DIR__ . '/error-404.html',
        $fileSystem
    )->contents()
);

$emitter = new Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter();
$emitter->emit($response);
exit;
