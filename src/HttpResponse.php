<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;
use Nyholm\Psr7\Stream as PsrStream;

use Eightfold\HTMLBuilder\Document;
use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\File;

use JoshBruce\Site\Content\Markdown;

use JoshBruce\Site\PageComponents\Navigation;

class HttpResponse
{
    private ResponseInterface $psrResponse;

    public static function from(HttpRequest $request): HttpResponse
    {
        return new HttpResponse($request);
    }

    private function __construct(private HttpRequest $request)
    {
    }

    public function statusCode(): int
    {
        if ($this->request->isMissingRequiredValues()) {
            return 500;

        } elseif ($this->request->isUnsupportedMethod()) {
            return 405;

        } elseif ($this->request->isNotFound()) {
            return 404;

        }
        return 200;
    }

    /**
     * @return array<string, int|string|string[]>
     */
    public function headers(): array
    {
        $headers = [];
        if ($this->statusCode() === 200) {
            $headers['Content-Type'] = $this->request->localFile()->mimeType();

        } elseif ($this->statusCode() === 404) {
            $headers['Content-Type'] = 'text/html';

        }

        return $headers;
    }

    public function body(): string
    {
        $localFile = $this->request->localFile();
        if ($this->statusCode() === 200 and $localFile->isNotMarkdown()) {
            return $localFile->path();

        } elseif ($this->statusCode() === 404) {
            $localPath = FileSystem::contentRoot() . '/public/error-404.md';
            $localFile = File::at($localPath);

        } elseif ($this->statusCode() === 405) {
            $localPath = FileSystem::contentRoot() . '/public/error-405.md';
            $localFile = File::at($localPath);

        }

        $html = '';
        $pageTitle = '';
        if ($localFile->isMarkdown()) {
            $markdown  = Markdown::for(file: $localFile);
            $pageTitle = $markdown->pageTitle();
            $html      = $markdown->html();

        }

        return Document::create(
            $pageTitle
        )->head(
            Element::meta()->omitEndTag()->props(
                'name viewport',
                'content width=device-width,initial-scale=1'
            ),
            Element::link()->omitEndTag()->props(
                'type image/x-icon',
                'rel icon',
                'href /assets/favicons/favicon.ico'
            ),
            Element::link()->omitEndTag()->props(
                'rel apple-touch-icon',
                'href /assets/favicons/apple-touch-icon.png',
                'sizes 180x180'
            ),
            Element::link()->omitEndTag()->props(
                'rel image/png',
                'href /assets/favicons/favicon-32x32.png',
                'sizes 32x32'
            ),
            Element::link()->omitEndTag()->props(
                'rel image/png',
                'href /assets/favicons/favicon-16x16.png',
                'sizes 16x16'
            ),
            $this->cssElement()
        )->body(
            Element::a('menu')->props('href #main-nav', 'id content-top'),
            Element::article(
                $html
            )->props('typeof BlogPosting', 'vocab https://schema.org/'),
            Element::a('top')->props('href #content-top', 'id go-to-top'),
            Navigation::create('main.md'),
            Element::footer(
                Element::p(
                    'Copyright © 2004–' . date('Y') . ' Joshua C. Bruce. ' .
                        'All rights reserved.'
                )
            )
        )->build();
    }

    public function cssElement(): Element
    {
        $cssPath  = '/assets/css/main.min.css';
        // $filePath = $contentRoot . $cssPath;
        // TODO: should be last commit of CSS file - another reason to place
        //       content in same folder as rest of project.
        $query = round(microtime(true));

        return Element::link()->omitEndTag()
            ->props('rel stylesheet', "href {$cssPath}?v={$query}");
    }

    public function psrResponse(): ResponseInterface
    {
        if (! isset($this->psrResponse)) {
            $psr17Factory = new PsrFactory();
            $body         = $this->body();
            $stream       = $psr17Factory->createStream($body);
            if ($this->request->isFile()) {
                $stream = $psr17Factory->createStreamFromFile($body);
            }

            $this->psrResponse = new PsrResponse(
                $this->statusCode(),
                $this->headers(),
                $stream
            );
        }
        return $this->psrResponse;
    }
}
