<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use JoshBruce\Site\Emitter;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

// -> 500 server code dotenv required variables not set
$envHasRequired = array_key_exists('CONTENT_UP', $_SERVER) and
    array_key_exists('CONTENT_FOLDER', $_SERVER);

if (! $envHasRequired) {
    $emitter = Emitter::create(
        500,
        'Iternal server error',
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ]
    );

    $emitter->emitStatusLine();
    $emitter->emitHeaders();
    $emitter->emitBody();

    exit;
}

// -> 500 server code no content connection possible
$contentUp      = $_SERVER['CONTENT_UP'];
$contentFolder  = $_SERVER['CONTENT_FOLDER'];
$contentStart   = __DIR__;
$contentParts   = explode('/', $contentStart);
$contentParts   = array_slice($contentParts, 0, -1 * $contentUp);
$contentParts[] = $contentFolder;
$contentRoot    = implode('/', $contentParts);

$contentExists = file_exists($contentRoot) and is_dir($contentRoot);

if (! $contentExists) {
    $emitter = Emitter::create(
        502,
        'Bad gateway',
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ]
    );

    $emitter->emitStatusLine();
    $emitter->emitHeaders();
    $emitter->emitBody();

    exit;
}

// -> 404 server code no valid content
$contentRoot    = $contentRoot;
$requestUri     = $_SERVER['REQUEST_URI'];
$requestAbspath = $contentRoot . $requestUri . '/content.md';

$contentExists = file_exists($requestAbspath) and is_file($requestAbspath);

if (! $contentExists) {
    $emitter = Emitter::create(
        404,
        'Not found',
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ]
    );

    $emitter->emitStatusLine();
    $emitter->emitHeaders();
    $emitter->emitBody();

    exit;
}

$emitter = Emitter::create(
    200,
    'Ok',
    [
        'Cache-Control' => ['max-age=600']
    ]
);

$emitter->emitStatusLine();
$emitter->emitHeaders();
$emitter->emitBody();

exit;
