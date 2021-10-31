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
        $headElements   = [
            HtmlElement::meta()
                ->props('name viewport', 'content width=device-width,initial-scale=1')
        ];

        $headElements = array_merge($headElements, Favicons::create());

        $headElements[] = HtmlElement::link()
            ->props('rel stylesheet', 'href /assets/css/main.min.css');
        return $headElements;
    }
}
