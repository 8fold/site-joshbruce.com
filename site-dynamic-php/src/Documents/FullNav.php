<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Documents;

use Eightfold\HTMLBuilder\Document;
use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class FullNav
{
    public static function create(
        string $pageTitle,
        string $description,
        Element $body,
        Environment $environemt
    ): string {
        $html = Document::create(
            $pageTitle
        )->head(
            ...HtmlDefault::baseHead($description)
        )->body(
            Element::main($body),
            HtmlDefault::footer()
        )->build();

        return HtmlDefault::canonicalUrls($html, $environemt);
    }
}
