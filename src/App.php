<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use \Stringable;

use Eightfold\HTMLBuilder\Document as HtmlDocument;
use Eightfold\HTMLBuilder\Element as HtmlElement;

class App implements Stringable
{
    public static function run(): App
    {
        return new App();
    }

    public function __toString(): string
    {
        return (string) HtmlDocument::create(
            'Hello, World!'
        )->body(
            HtmlElement::p('Hello, World!')
        );
    }
}
