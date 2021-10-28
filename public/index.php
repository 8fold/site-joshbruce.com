<?php

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
    $content = JoshBruce\Site\Content::init($projectRoot, 0, '/setup-errors')
        ->for('/500.md');

    JoshBruce\Site\Emitter::emitWithResponse(
        500,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        Eightfold\HTMLBuilder\Document::create(
                $markdownConverter->getFrontMatter($content->markdown())['title']
            )->body(
                $markdownConverter->convert($content->markdown())
            )->build()
    );
    exit;
}

if ($server->isUsingUnsupportedMethod()) {
    $content = JoshBruce\Site\Content::init($projectRoot, 0, '/setup-errors')
        ->for('/405.md');

    JoshBruce\Site\Emitter::emitWithResponse(
        405,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ],
            'Allow' => $server->supportedMethods()
        ],
        Eightfold\HTMLBuilder\Document::create(
                $markdownConverter->getFrontMatter($content->markdown())['title']
            )->body(
                $markdownConverter->convert($content->markdown())
            )->build()
    );
    exit;
}

$content = JoshBruce\Site\Content::init(
    $projectRoot,
    $server->contentUp(),
    $server->contentFolder()
);

if ($content->folderIsMissing()) {
    $content = JoshBruce\Site\Content::init($projectRoot, 0, '/setup-errors')
        ->for('/502.md');

    JoshBruce\Site\Emitter::emitWithResponse(
        502,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        Eightfold\HTMLBuilder\Document::create(
                $markdownConverter->getFrontMatter($content->markdown())['title']
            )->body(
                $markdownConverter->convert($content->markdown())
            )->build()
    );
    exit;
}

$content = $content->for($server->filePathForRequest());
if ($content->notFound()) {
    $content = $content->for(path: '/.errors/404.md');
    JoshBruce\Site\Emitter::emitWithResponse(
        404,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        Eightfold\HTMLBuilder\Document::create(
                $markdownConverter->getFrontMatter($content->markdown())['title']
            )->body(
                $markdownConverter->convert($content->markdown())
            )->build()
    );
    exit;
}

if ($server->isRequestingFile()) {
    JoshBruce\Site\Emitter::emitWithResponseFile(
        200,
        [
            'Cache-Control' => ['max-age=2592000'],
            'Content-Type'  => $content->mimeType()
        ],
        $content->filePath()
    );
    exit;
}

/**
 * Target file wants to redirect us: local response time 40ms
 */
$redirectPath = $content->redirectPath();
if (strlen($redirectPath) > 0) {
    $scheme        = $_SERVER['REQUEST_SCHEME'];
    $serverName    = $_SERVER['HTTP_HOST'];
    $requestDomain = $scheme . '://' . $serverName;
    JoshBruce\Site\Emitter::emitWithResponse(
        301,
        [
            'Location' => $requestDomain . $redirectPath
        ]
    );
    exit;
}

/**
 * Process HTML response: local response time 75ms (90ms with table content)
 */

$markdownConverter = $markdownConverter->tables();

$headers['Content-Type'] = $content->mimeType();

$headElements   = JoshBruce\Site\PageComponents\Favicons::create();
$headElements[] = Eightfold\HTMLBuilder\Element::link()
    ->props('rel stylesheet', 'href /css/main.css');

$body = Eightfold\HTMLBuilder\Document::create(
        $markdownConverter->getFrontMatter($content->markdown())['title']
    )->head(
        ...$headElements
    )->body(
        JoshBruce\Site\PageComponents\Navigation::create($content)
            ->build(),
        $markdownConverter->convert($content->markdown())
    )->build();

JoshBruce\Site\Emitter::emitWithResponse(200, $headers, $body);
exit;
