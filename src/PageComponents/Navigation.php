<?php
declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Content;

class Navigation implements Buildable
{
    private UriInterface $uri;

    private string $domain = '';

    public static function create(
        Content $contentIn,
        RequestInterface $request
    ): self {
        return new self($contentIn, $request);
    }

    final private function __construct(
        private Content $contentIn,
        private RequestInterface $request
    ) {
    }

    private function request(): RequestInterface
    {
        return $this->request;
    }

    private function uri(): UriInterface
    {
        if (isset($this->uri) === false) {
            $this->uri = $this->request()->getUri();
        }
        return $this->uri;
    }

    private function domain(): string
    {
        if (strlen($this->domain) === 0) {
            $this->domain = $this->uri()->getAuthority();
        }
        return $this->domain;
    }

    private function path(): string
    {
        return $this->uri()->getPath();
    }

    private function spans(string $title, string $titleShort): array
    {
        return [
            Element::span($title),
            Element::span($titleShort)->props('aria-label ' . $title)
        ];
    }

    public function build(): string
    {
        $links = [
            '/ H Home',
            '/books/ B My books',
            '/essays-and-editorials/ E&E Essays and Editorials',
            '/experiences/ Exp. Experiences',
            '/examinations/ Exam. Examinations'
        ];

        $l = [];
        $requestPath = $this->path();
        foreach ($links as $link) {
            list($href, $ts, $title) = explode(' ', $link, 3);
            $id = str_replace('/', '', $href);

            $a = Element::a(
                ...$this->spans($title, $ts)
            )->props('href ' . $href);
            if ($requestPath === '/' and $href === $requestPath) {
                $a = Element::a(
                    ...$this->spans($title, $ts)
                )->props('href ' . $href, 'class current');

            } elseif (
                $href !== '/' and
                str_starts_with($requestPath, $href)
            ) {
                $a = Element::a(
                    ...$this->spans($title, $ts)
                )->props('href ' . $href, 'class current');

            }

            $l[] = Element::li($a);
        }

        return Element::nav(
            Element::ul(...$l)->props('class col-' . count($links))
        )->props('is main-nav')->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
