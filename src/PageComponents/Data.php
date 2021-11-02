<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Carbon\Carbon;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\Content\FrontMatter;

class Data
{
    public static function create(FrontMatter $frontMatter): HtmlElement|string
    {
        $listHeadings = [];
        foreach ($frontMatter->data() as $row) {
            $label   = $row[0];
            $current = $row[3];
            $low     = $row[1];
            $high    = $row[2];

            $detail = 'hold';
            if ($current > $high) {
                $detail = 'decrease';

            } elseif ($current < $low) {
                $detail = 'increase';

            }

            $listHeadings[] = Htmlelement::li(
                $label . " ({$detail})",
                HtmlElement::ul(
                    HtmlElement::li(
                        HtmlElement::b('current: '),
                        $current
                    ),
                    HtmlElement::li(
                        HtmlElement::abbr('min')->props('title minimum'),
                        ': ',
                        $low
                    ),
                    HtmlElement::li(
                        HtmlElement::abbr('max')->props('title maximum'),
                        ': ',
                        $high
                    )
                )
            );
        }
        return HtmlElement::ul(...$listHeadings);
    }
}
