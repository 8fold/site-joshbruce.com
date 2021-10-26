<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Stream as Stream;

use Eightfold\HTMLBuilder\Document as HtmlDocument;
use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\Content;
use JoshBruce\Site\Environment;
use JoshBruce\Site\Response;
use JoshBruce\Site\ResponseFile;

class App
{
    private const HIDDEN = [
        'css' => '/.assets/styles'
    ];

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

    public function response(): Response|ResponseFile
    {
        if ($this->isRequestingFile()) {
            $content = $this->content()->for(
                path: $this->localFilePathWithoutRoot()
            );
            if ($content->exists()) {
                $status  = 200;
                $reason  = 'Ok';
                $headers = [
                    'Cache-Control' => ['max-age=2592000'],
                    'Content-Type'  => $content->mimeType()
                ];
                return ResponseFile::create(
                    status: $status,
                    headers: $headers,
                    file: $content->filePath()
                );
            }
        }

        $file = $this->requestUri() . '/content.md';
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

        $body = HtmlDocument::create($content->title())->head(
            HtmlElement::link()->props('rel stylesheet', 'href /css/main.css')
        )->body(
            $content->html()
        )->build();

        return Response::create(
            status: $status,
            headers: $headers,
            body: $body
        );
    }

    private function isRequestingFile(): bool
    {
        // Informal check, because I don't need to be defensive and account for
        // a URL request path with a period in it - I'll only use hyphens.
        return strpos($this->requestUri(), '.') > 0;
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function localFilePathWithoutRoot(): string
    {
        $parts   = explode('/', $this->requestUri());
        $parts   = array_filter($parts);
        $first   = array_shift($parts);
        $search  = '/' . $first;
        $replace = self::HIDDEN[$first];

        return str_replace($search, $replace, $this->requestUri());
    }

    private function requestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}
