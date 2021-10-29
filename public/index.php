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

if ($server->isUsingUnsupportedMethod()) {
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

/**
 * Process HTML response: local response time 75ms (90ms with table content)
 */

$page = JoshBruce\Site\Pages\Default::create($markdownConverter, $content);
$markdownConverter = $markdownConverter->withConfig(['html_input' => 'allow'])
    ->tables()->externalLinks();

$headers['Content-Type'] = $content->mimeType();

$headElements   = JoshBruce\Site\PageComponents\Favicons::create();
$headElements[] = Eightfold\HTMLBuilder\Element::link()
    ->props('rel stylesheet', 'href /css/main.css');

$markdown = $content->markdown();

$frontMatter = $markdownConverter->getFrontMatter($content->markdown());

$updated = '';
if (array_key_exists('updated', $frontMatter)) {
    $updated = Eightfold\HTMLBuilder\Element::p(
        "Updated on: {$frontMatter['updated']}"
    );
}

$dateBlock = Eightfold\HTMLBuilder\Element::div(
        Eightfold\HTMLBuilder\Element::p("Created on: {$frontMatter['created']}"),
        $updated
    )->props('is dateblock');

$body = $markdownConverter->getBody($markdown);

$body = $dateBlock . $body;

if (array_key_exists('header', $frontMatter)) {
    $body = "# {$frontMatter['header']}\n\n" . $body;

} else {
    $body = "# {$frontMatter['title']}\n\n" . $body;

}

if (array_key_exists('type', $frontMatter) and $frontMatter['type'] === 'log') {
    $contents = $content->contentInSubfolders();
    krsort($contents);
    $logLinks = [];
    foreach ($contents as $key => $c) {
        if (! str_starts_with(strval($key), '_') and $c->exists()) {
            $logLinks[] = Eightfold\HTMLBuilder\Element::li(
                Eightfold\HTMLBuilder\Element::a(
                    $c->frontMatter()['title']
                )->props('href ' . $c->pathWithoutFile())
            );
        }
    }
    $list = Eightfold\HTMLBuilder\Element::ul(...$logLinks)->build();
    $body = $body . $list;
}

$body = Eightfold\HTMLBuilder\Document::create(
        $frontMatter['title']
    )->head(
        ...$headElements
    )->body(
        JoshBruce\Site\PageComponents\Navigation::create($content)
            ->build(),
        $markdownConverter->convert($body),
        Eightfold\HTMLBuilder\Element::footer(
            Eightfold\HTMLBuilder\Element::p(
                'Copyright © 2004–' . date('Y') . 'Joshua C. Bruce. ' .
                    'All rights reserved.'
            )
        )
    )->build();

JoshBruce\Site\Emitter::emitWithResponse(200, $headers, $body);
exit;
