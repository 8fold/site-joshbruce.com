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

            return Response::create(
                status: 303,
                headers: [
                    'Location' =>  $this->requestDomain() . $path
                ]);
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

        $body = HtmlDocument::create($content->title())->head(
            HtmlElement::link()->props(
                'type image/x-icon',
                'rel icon',
                'href /assets/favicons/favicon.ico'
            ),
            HtmlElement::link()->props(
                'rel apple-touch-icon',
                'href /assets/favicons/apple-touch-icon.png',
                'sizes 180x180'
            ),
            HtmlElement::link()->props(
                'rel image/png',
                'href /assets/favicons/favicon-32x32.png',
                'sizes 32x32'
            ),
            HtmlElement::link()->props(
                'rel image/png',
                'href /assets/favicons/favicon-16x16.png',
                'sizes 16x16'
            ),
            HtmlElement::link()->props('rel stylesheet', 'href /css/main.css'),
            // HtmlElement::script()->props('src /js/menu.js')
        )->body(
            HtmlElement::nav(
                HtmlElement::form(
                    HtmlElement::div(
                        HtmlElement::label('navigation: ')->props(
                            'id change-page-select-label',
                            'for change-page-select'
                        ),
                        HtmlElement::select(
                            HtmlElement::option('home')->props(
                                'value /',
                                'selected selected'
                            ),
                            HtmlElement::optgroup(
                                HtmlElement::option('Overview')
                                    ->props('value /finances'),
                                HtmlElement::option('Investment policy')
                                    ->props('value /finances/investment-policy'),
                                HtmlElement::option('Paycheck to paycheck')
                                    ->props('value /finances/building-wealth-paycheck-to-paycheck')
                            )->props('label Finances'),
                            HtmlElement::optgroup(
                                HtmlElement::option('Overview')
                                    ->props('value /design-your-life'),
                                HtmlElement::option('Motivators')
                                    ->props('value /design-your-life/motivators')
                            )->props('label Design your life'),
                            HtmlElement::optgroup(
                                HtmlElement::option('Overview')
                                    ->props('value /software-development'),
                                HtmlElement::option('Why donʼt you use')
                                    ->props('value /software-development/why-dont-you-use')
                            )->props('label Software development')
                        )->props(
                            'id change-page-select',
                            'name change-page-select'
                        )
                    )->props('is form-control'),
                    HtmlElement::button('Go!')
                )->props('action /', 'method post'),
            )->props('id main-nav-form'),
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
