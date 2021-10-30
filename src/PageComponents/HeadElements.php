<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\PageComponents\Favicons;

class HeadElements
{
    /**
     * @return array<int, HtmlElement>
     */
    public static function create(): array
    {
        $headElements   = Favicons::create();
        $headElements[] = HtmlElement::link()
            ->props('rel stylesheet', 'href /css/main.css');
        return $headElements;
    }
}
