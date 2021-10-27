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
use JoshBruce\Site\PageComponents\Favicons;
use JoshBruce\Site\PageComponents\Navigation;

class App
{
    private const HIDDEN = [
        '/css'    => '/.assets/styles',
        '/js'     => '/.assets/scripts',
        '/assets' => '/.assets'
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
        $status = 200;
        $headers = [
            'Cache-Control' => ['max-age=600']
        ];

        $content = $this->content()
            ->for(path: $this->localFilePathWithoutRoot());
        if ($content->notFound()) {
            // MANUAL: Our tests don't run in a browser environemtn; therefore,
            //         don't believe it's possible to write an automated test for
            //         this given current setup.
            // don't like that this path doesn't return early.
            // TODO: refactor this
            //       - believe a defalt page template would resolve the issue
            $content = $this->content()->for(path: '/.errors/404.md');

            $status  = 404;
            $headers = [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate',

                ]
            ];

        } elseif ($this->isRequestingFile()) {
            $headers = [
                'Cache-Control' => ['max-age=2592000'],
                'Content-Type'  => $content->mimeType()
            ];
            return ResponseFile::create(
                status: $status,
                headers: $headers,
                file: $content->filePath()
            );

        } elseif ($this->isRedirecting()) {
            return Response::create(
                status: 301,
                headers: [
                    'Location' => $this->requestDomain() .
                        $this->content()->redirectPath()
                ]
            );
        }

        $headers['Content-Type'] = $content->mimeType();

        $headElements   = Favicons::create();
        $headElements[] = HtmlElement::link()
            ->props('rel stylesheet', 'href /css/main.css');
        // $headElements[] = HtmlElement::script()->props('src /js/menu.js');

        $body = HtmlDocument::create($content->title())
            ->head(...$headElements)
            ->body(
                Navigation::create($this->content())->build(),
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

    private function isRedirecting(): bool
    {
        return strlen($this->content()->redirectPath()) > 0;
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function localFilePathWithoutRoot(): string
    {
        if ($this->isRequestingFile()) {
            $parts   = explode('/', $this->requestUri());
            $parts   = array_filter($parts);
            $first   = array_shift($parts);
            $search  = '/' . $first;

            if (array_key_exists($search, self::HIDDEN)) {
                $replace = self::HIDDEN[$search];

                return str_replace($search, $replace, $this->requestUri());
            }
        }
        return $this->requestUri() . '/content.md';
    }

    private function requestDomain(): string
    {
        $scheme = $_SERVER['REQUEST_SCHEME'];
        $serverName = $_SERVER['HTTP_HOST'];
        return $scheme . '://' . $serverName;
    }

    private function requestMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    private function requestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}
