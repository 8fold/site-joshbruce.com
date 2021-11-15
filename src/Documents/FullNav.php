<?php

declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Eightfold\HTMLBuilder\Document;
use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\File;

use JoshBruce\Site\Documents\HtmlDefault;

use JoshBruce\Site\PageComponents\Navigation;

use JoshBruce\Site\Content\Markdown;

class FullNav
{
    public static function create(File $file): string
    {
        $pageTitle   = $file->pageTitle();
        $html        = '';
        $description = '';
        if ($file->isMarkdown()) {
            $markdown  = Markdown::for(
                file: $file,
                in: $file->fileSystem()
            );
            $html        = $markdown->html();
            $description = $markdown->description();
        }

        $html = Document::create(
            $pageTitle
        )->head(
            ...HtmlDefault::baseHead($description)
        )->body(
            Element::main($html),
            Element::footer(
                Element::p(
                    'Copyright © 2004–' . date('Y') . ' Joshua C. Bruce. ' .
                        'All rights reserved.'
                )
            )
        )->build();

        return $html;
    }
}
