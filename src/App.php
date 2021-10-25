<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Eightfold\HTMLBuilder\Document as HtmlDocument;

use JoshBruce\Site\Content;
use JoshBruce\Site\Environment;
use JoshBruce\Site\Response;
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

    public function content(): Content
    {
        return $this->environment()->content();
    }

    public function response(): Response
    {
        $file    = $this->environment()->server()->requestUri() . '/content.md';
        $content = $this->content()->for(path: $file);
        $status  = 200;
        $reason  = 'Ok';
        $headers = [
            'Cache-Control' => ['max-age=600']
        ];
        if (! $content->exists()) {
            $status  = 404;
            $file    = '/.errors/404.md';
            $reason  = 'Not found';
            $headers = [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ];
            $content = $this->content()->for(path: $file);
        }

        $body = HtmlDocument::create($content->title())->body(
            $content->html()
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

    // private function requestFilePath(): string
    // {
    //     $contentRoot     = $this->environment()->content()->root();
    //     $requestParts    = explode('/', $contentRoot);
    //     $requestUriParts = explode(
    //         '/',
    //         $this->environment()->server()->requestUri()
    //     );
    //     $parts           = array_merge($requestParts, $requestUriParts);
    //     $parts[]         = 'content.md';
    //     $parts           = array_filter($parts);

    //     return '/' . implode('/', $parts);
    // }

    // private function contentExistsForRequest(): bool
    // {
    //     return file_exists($this->requestFilePath()) and
    //         is_file($this->requestFilePath());
    // }
}
