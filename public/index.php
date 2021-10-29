<?php

declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

require $projectRoot . '/vendor/autoload.php';

/**
 * Rergardless of what happens next, we'll need a basline markown converter.
 *
 * We only want the bare minimum setup in the beginning.
 */
$markdownConverter = Eightfold\Markdown\Markdown::create()
    ->minified()
    ->smartPunctuation();

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable($projectRoot)->load();

$server = JoshBruce\Site\Server::init($_SERVER);

if ($server->isMissingRequiredValues()) {
    JoshBruce\Site\Emitter::emitInterServerErrorResponse(
        $markdownConverter,
        $projectRoot
    );
    exit;
}

if ($server->isRequestingUnsupportedMethod()) {
    JoshBruce\Site\Emitter::emitUnsupportedMethodResponse(
        $markdownConverter,
        $projectRoot,
        $server
    );
    exit;
}

$content = JoshBruce\Site\Content::init(
    $projectRoot,
    $server->contentUp(),
    $server->contentFolder()
);

if ($content->folderIsMissing()) {
    JoshBruce\Site\Emitter::emitBadContentResponse(
        $markdownConverter,
        $projectRoot
    );
    exit;
}

// TESTING: Redirection
// Check browser address becomes /design-your-life
// if ($server->requestUri() !== '/design-your-life') {
//     $_SERVER['REQUEST_URI'] = '/self-improvement';
//     $server = JoshBruce\Site\Server::init($_SERVER);
// }

$content = $content->for($server->filePathForRequest());

if ($content->notFound()) {
    JoshBruce\Site\Emitter::emitNotFoundResponse(
        $markdownConverter,
        $content,
        '/.errors/404.md'
    );
    exit;
}

if ($server->isRequestingFile()) {
    JoshBruce\Site\Emitter::emitFile($content->mimeType(), $content->filePath());
    exit;
}

if ($content->hasMoved()) {
    $location = $server->domain() . $content->redirectPath();
    JoshBruce\Site\Emitter::emitRedirectionResponse($location);
    exit;
}

$page = JoshBruce\Site\Pages\DefaultTemplate::create(
    $markdownConverter,
    $content
);

JoshBruce\Site\Emitter::emitWithResponse(200, $page->headers(), $page->body());
exit;
