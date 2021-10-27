<?php

namespace JoshBruce\Site\PageComponents;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\Content;

class Navigation implements Buildable, Stringable
{
    public static function create(Content $content): Navigation
    {
        return new Navigation($content);
    }

    public function __construct(private Content $content)
    {
        $this->content = clone $content;
    }

    private function content(): Content
    {
        return $this->content;
    }

    private function listItem(string $for): HtmlElement
    {
        return HtmlElement::li(
            $this->anchor(for: $for)
        );
    }

    private function anchor(string $for): HtmlElement
    {
        list($href, $text) = explode(' ', $for, 2);
        return HtmlElement::a($text)->props('href ' . $href);
    }

    /**
     * @return array<string|array<string>>
     */
    private function navigation(): array
    {
        $nav = $this->content()->for(path: '/.navigation/main.md')
            ->frontMatter();
        $nav = $nav['navigation'];
        if (is_array($nav)) {
            return $nav;
        }
        return [];
    }

    public function build(): string
    {
        $li = [];
        $nav = $this->navigation();
        foreach ($nav as $item) {
            if (is_string($item)) {
                $li[] = $this->listItem(for: $item);

            } elseif (is_array($item)) {
                $l = '';
                $s = [];
                for ($i = 0; $i < count($item); $i++) {
                    if ($i === 0) {
                        $l = $this->anchor($item[$i]);

                    } else {
                        $s[] = $this->listItem($item[$i]);

                    }
                }

                $li[] = HtmlElement::li($l, HtmlElement::ul(...$s));
            }
        }
        return HtmlElement::nav(
            HtmlElement::ul(...$li)
        );
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
