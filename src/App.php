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
        if ($this->requestMethod() === 'post') {
            // used for navigation only
            // no CSRF token needed
            $path = $_POST['change-page-select'];

            // could not figure out a proper response code for this
            // just redirecting without a response code
            header('Location:' . $this->requestDomain() . $path);
            exit;
        }

        $status = 200;
        $headers = [
            'Cache-Control' => ['max-age=600']
        ];

        $content = $this->content()
            ->for(path: $this->localFilePathWithoutRoot());
        if ($content->notFound()) {
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
