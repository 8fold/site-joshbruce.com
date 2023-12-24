<?php
declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Stringable;
// use Eightfold\XMLBuilder\Contracts\Buildable;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class Navigation implements Stringable // Buildable
{
    public static function create(Site $site, string $requestPath): self
    {
        return new self($site, $requestPath);
    }

    final private function __construct(
        private readonly Site $site,
        private readonly string $requestPath
    ) {
    }

    public function site(): Site
    {
        return $this->site;
    }

    /**
     *
     * @param string $title
     * @param string $titleShort
     *
     * @return Element[]
     */
    private function spans(string $title, string $titleShort): array
    {
        return [
            Element::span($title),
            Element::span($titleShort)->props('aria-label ' . $title)
        ];
    }

    public function __toString(): string
    {
        $links = [
            '/ H Home',
            '/books/ B My books',
            '/essays-and-editorials/ E&E Essays and Editorials',
            '/experiences/ Exp. Experiences',
            '/examinations/ Exam. Examinations'
        ];

        $l = [];
        $requestPath = $this->requestPath;
        foreach ($links as $link) {
            list($href, $ts, $title) = explode(' ', $link, 3);

            $a = Element::a(
                ...$this->spans($title, $ts)
            )->props('href ' . $href);
            if ($requestPath === '/' and $href === $requestPath) {
                $a = Element::a(
                    ...$this->spans($title, $ts)
                )->props(
                    'href ' . $href,
                    'class current',
                    'aria-current true'
                );

            } elseif (
                $href !== '/' and
                str_starts_with($requestPath, $href)
            ) {
                $a = Element::a(
                    ...$this->spans($title, $ts)
                )->props(
                    'href ' . $href,
                    'class current',
                    'aria-current true'
                );

            }

            $l[] = Element::li($a);
        }

        return (string) Element::nav(
            Element::ul(...$l)->props('class col-' . count($links))
        )->props('is main-nav', 'aria-label primary navigation');
    }
}
