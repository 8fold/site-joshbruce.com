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
    public static function init(Environment $environment): App
    {
        return new App($environment);
    }

    final public function __construct(private Environment $environment)
    {
    }

    public function markdownConverter(): Markdown
    {
        return $this->environment()->markdownConverter();
    }

    public function response(): Response
    {
        $m = $this->markdownConverter();

        $status  = 404;
        $file    = '/.errors/404.md';
        $reason  = 'Not found';
        $headers = [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ];
        if ($this->contentExistsForRequest()) {
            $status  = 200;
            $file    = '/content.md';
            $reason  = 'Ok';
            $headers = [
                'Cache-Control' => ['max-age=600']
            ];
        }

        $markdown = file_get_contents(
            $this->environment()->content()->root() .
            $file
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
            $status,
            headers: $headers,
            body: $body,
            reason: $reason
        );
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function requestFilePath(): string
    {
        $contentRoot     = $this->environment()->content()->root();
        $requestParts    = explode('/', $contentRoot);
        $requestUriParts = explode(
            '/',
            $this->environment()->server()->requestUri()
        );
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
