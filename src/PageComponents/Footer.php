<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element as HtmlElement;

class Footer
{
    public static function create(): HtmlElement
    {
        return HtmlElement::footer(
            HtmlElement::p(
                'Copyright © 2004–' . date('Y') . 'Joshua C. Bruce. ' .
                    'All rights reserved.'
            )
        );
    }
}
