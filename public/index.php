<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

require $projectRoot . '/vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable($projectRoot)->load();

$server = JoshBruce\Site\Server::init($_SERVER, $projectRoot);

if ($server->isMissingRequiredValues()) {
    JoshBruce\Site\Emitter::emitInteralServerErrorResponse(
        JoshBruce\Site\Content\Markdown::markdownConverter(),
        $projectRoot
    );
    exit;
}

if ($server->isRequestingUnsupportedMethod()) {
    JoshBruce\Site\Emitter::emitUnsupportedMethodResponse(
        JoshBruce\Site\Content\Markdown::markdownConverter(),
        $projectRoot,
        $server
    );
    exit;
}

$fileSystem = JoshBruce\Site\FileSystem::init(
    $server->contentRoot(),
    $server->requestUriWithoutFileName(),
    $server->requestFileName()
);

if ($fileSystem->rootFolderIsMissing()) {
    JoshBruce\Site\Emitter::emitBadContentResponse(
        JoshBruce\Site\Content\Markdown::markdownConverter(),
        $projectRoot
    );
    exit;
}

// TESTING: Redirection
// Check browser address becomes /design-your-life
// if ($server->requestUriWithoutFileName() !== '/design-your-life') {
//     $_SERVER['REQUEST_URI'] = '/self-improvement';
//     $server = JoshBruce\Site\Server::init($_SERVER, $projectRoot);
// }

$fileSystem = $fileSystem->with(
    folderPath: $server->requestUriWithoutFileName(),
    fileName: $server->requestFileName()
);

// die(var_dump($fileSystem->filePath()));
if ($fileSystem->notFound()) {
    $fileSystem = $fileSystem->with('/content', '404.md');
    JoshBruce\Site\Emitter::emitNotFoundResponse(
        JoshBruce\Site\Content\Markdown::markdownConverter(),
        $fileSystem
    );
    exit;
}

if ($server->isRequestingFile()) {
    JoshBruce\Site\Emitter::emitFile($fileSystem->mimeType(), $fileSystem->filePath());
    exit;
}

$markdown = JoshBruce\Site\Content\Markdown::init($fileSystem);
if ($markdown->hasMoved()) {
    $location = $server->domain() . $markdown->redirectPath();
    JoshBruce\Site\Emitter::emitRedirectionResponse($location);
    exit;
}

$page = JoshBruce\Site\Pages\DefaultTemplate::create(
    JoshBruce\Site\Content\Markdown::init($fileSystem)->convert(),
    $fileSystem->mimeType(),
    $fileSystem
    // JoshBruce\Site\Content\Markdown::markdownConverter(),
    // $markdown
);

JoshBruce\Site\Emitter::emitWithResponse(200, $page->headers(), $page->body());
exit;
