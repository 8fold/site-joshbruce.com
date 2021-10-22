<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\Amos\Store;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\Proxies\Uri;

class Head
{
    public static function create(
        Store $store,
        string $pageTitle,
        string $fullUrl = ''
    ): array {
        $head = new Head($store, $pageTitle, $fullUrl);
        return $head->elements();
    }

    public function __construct(
        private Store $store,
        private string $pageTitle,
        private string $fullUrl = ''
    ) {
    }

    public function elements(): array
    {
        $elements = [];
        $elements[] = HtmlElement::meta()->props(
            'name viewport',
            'content width=device-width,initial-scale=1'
        )->omitEndTag();

        return array_merge(
            $elements,
            // $this->favicons(),
            // $this->social(),
            $this->styles(),
            // $this->scripts()
        );
    }

    private function store(): Store
    {
        return $this->store;
    }

    private function pageTitle(): string
    {
        return $this->pageTitle;
    }

    private function url(): string
    {
        return $this->fullUrl;
    }

    private function favicons(): array
    {
        return [
            HtmlElement::link()->props(
                'rel icon',
                'type image/x-icon',
                'href /assets/favicons/favicon.ico'
            )->omitEndTag(),
            HtmlElement::link()->props(
                'rel apple-touch-icon',
                'sizes 180x180',
                'href /assets/favicons/apple-touch-icon.png'
            )->omitEndTag(),
            HtmlElement::link()->props(
                'rel image/png',
                'sizes 32x32',
                'href /assets/favicons/favicon-32x32.png'
            )->omitEndTag(),
            HtmlElement::link()->props(
                'rel image/png',
                'sizes 16x16',
                'href /assets/favicons/favicon-16x16.png'
            )->omitEndTag()
        ];
    }

    private function social(): array
    {
        $poster = $this->poster();

        return [
            HtmlElement::meta()->props('content website', 'property og:type')
                ->omitEndTag(),
            HtmlElement::meta()->props(
                'content ' . $this->pageTitle(),
                'property og:title'
            )->omitEndTag(),
            HtmlElement::meta()->props(
                'content ' . $this->url(),
                'property og:url'
            )->omitEndTag(),
            HtmlElement::meta()->props(
                'content ' . $this->description(),
                'property og:description'
            )->omitEndTag(),
            (strlen($poster) === 0)
                ? ''
                : HtmlElement::meta()->props(
                    'content ' . $this->poster(),
                    'property og:image'
                )->omitEndTag()
        ];
    }

    private function styles(): array
    {
        $styles = [
            '/assets/styles/main.css'
        ];

        $b = [];
        foreach ($styles as $style) {
            $b[] = HtmlElement::link()->props(
                'rel stylesheet',
                'href ' . $style
            )->omitEndTag();
        }

        return $b;
    }

    private function scripts(): array
    {
        $scripts = [];

        $b = [];
        foreach ($scripts as $script) {
            $b[] = HtmlElement::script()->props('src ' . $script);
        }

        return $b;
    }

    private function isProduction(): bool
    {
        return env('APP_ENV') === 'production';
    }

    // private function isContactPage(): bool
    // {
    //     $path = request()->path();
    //     $parts = explode('/', $path);
    //     $first = array_shift($parts);
    //     return ($first === 'contact');
    // }

    // private function isEventsPage(): bool
    // {
    //     $path = request()->path();
    //     $parts = explode('/', $path);
    //     $first = array_shift($parts);
    //     return ($first === 'events');
    // }

    private function description(): string
    {
        $meta = $this->store()->markdown()->frontMatter();
        if (array_key_exists('description', $meta)) {
            return $meta['description'];

        } elseif (array_key_exists('title', $meta)) {
            return $meta['title'];

        }
        return "no description available";
    }

    private function poster(): string
    {
        $domain = $this->domain();

        $mediaStore = Store::create(
            $this->store()->root()
        )->media($this->store()->path());

        if ($mediaStore->hasFile('poster.png')) {
            $path = str_replace('/.media', '/media', $mediaStore->path());
            return $domain . $path . '/poster.png';
        }
        return '';
    }

    private function domain(): string
    {
        return Uri::authorityWithScheme();
    }
}
