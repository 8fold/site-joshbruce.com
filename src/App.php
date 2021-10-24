<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Eightfold\HTMLBuilder\Document as HtmlDocument;
use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Environment;
use JoshBruce\Site\Http\Response;
use JoshBruce\Site\Emitter;

class App
{
    /**
     * @param array<string, array<int, string>|string|int> $serverGlobals
     */
    public static function emitResponse(array $serverGlobals): void
    {
        $response = null;
        // Verify environment has minimal structure
        $env = Environment::init($_SERVER);
        if ($env->isVerified()) {
            $response = App::init($env)->response();

        } else {
            $response = $env->response();

        }
        Emitter::emit($response);
    }

    public static function init(Environment $environment): App
    {
        return new App($environment);
    }

    final public function __construct(private Environment $environment)
    {
    }

    public function response(): Response
    {
        $m = Markdown::create()->minified();

        if ($this->contentExistsForRequest()) {
            $markdown = file_get_contents(
                $this->environment()->contentRoot() .
                '/content.md'
            );

            if (is_bool($markdown)) {
                $markdown = '';
            }

            $meta = $m->getFrontMatter($markdown);
            $title = $meta['title'];

            $body = HtmlDocument::create($title)->body(
                $m->convert($markdown)
            )->build();

            return Response::create(
                200,
                headers: [
                    'Cache-Control' => ['max-age=600']
                ],
                body: $body,
                reason: 'Ok'
            );
        }

        $markdown = file_get_contents(
            $this->environment()->contentRoot() .
            '/.errors/404.md'
        );

        if (is_bool($markdown)) {
            $markdown = '';
        }

        $meta = $m->getFrontMatter($markdown);
        $title = $meta['title'];

        $body = HtmlDocument::create($title)->body(
            $m->convert($markdown)
        )->build();

        return Response::create(
            404,
            headers: [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            body: $body,
            reason: 'Not found'
        );
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function requestFilePath(): string
    {
        $contentRoot     = $this->environment()->contentRoot();
        $requestParts    = explode('/', $contentRoot);
        $requestUriParts = explode('/', $this->environment()->requestUri());
        $parts           = array_merge($requestParts, $requestUriParts);
        $parts[]         = 'content.md';
        $parts           = array_filter($parts);

        return '/' . implode('/', $parts);
    }

    private function contentExistsForRequest(): bool
    {
        return file_exists($this->requestFilePath()) and
            is_file($this->requestFilePath());
    }
}
