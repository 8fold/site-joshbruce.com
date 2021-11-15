<?php

declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Eightfold\HTMLBuilder\Document;
use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\File;

use JoshBruce\Site\PageComponents\Navigation;

use JoshBruce\Site\Content\Markdown;

class HtmlDefault
{
    public static function create(File $file): string
    {
        $template    = '';
        $pageTitle   = '';
        $html        = '';
        $description = '';
        if ($file->isMarkdown()) {
            $markdown  = Markdown::for(
                file: $file,
                in: $file->fileSystem()
            );
            $template    = $markdown->frontMatter()->template();
            $pageTitle   = $markdown->pageTitle();
            $html        = $markdown->html();
            $description = $markdown->description();
        }

        $html = Document::create(
            $pageTitle
        )->head(
            Element::meta()->omitEndTag()->props(
                'name viewport',
                'content width=device-width,initial-scale=1'
            ),
            Element::meta()->omitEndTag()->props(
                'name description',
                'content ' . $description
            ),
            Element::link()->omitEndTag()->props(
                'type image/x-icon',
                'rel icon',
                'href /assets/favicons/favicon.ico'
            ),
            Element::link()->omitEndTag()->props(
                'rel apple-touch-icon',
                'href /assets/favicons/apple-touch-icon.png',
                'sizes 180x180'
            ),
            Element::link()->omitEndTag()->props(
                'rel image/png',
                'href /assets/favicons/favicon-32x32.png',
                'sizes 32x32'
            ),
            Element::link()->omitEndTag()->props(
                'rel image/png',
                'href /assets/favicons/favicon-16x16.png',
                'sizes 16x16'
            ),
            self::cssElement()
        )->body(
            (strlen($template) === 0)
                ? Element::a('menu')->props('href #main-nav', 'id content-top')
                : '',
            (
                strlen($template) === 0 and
                str_replace('content.md', '', $file->path(false)) !== '/'
            )
                ? Element::article(
                    $html
                )->props('typeof BlogPosting', 'vocab https://schema.org/')
                : Element::main(
                    $html
                ),
            (strlen($template) === 0)
                ? Element::a('top')->props('href #content-top', 'id go-to-top')
                : '',
            (strlen($template) === 0)
                ? Navigation::create('main.md', $file->fileSystem())
                : '',
            Element::footer(
                Element::p(
                    'Copyright © 2004–' . date('Y') . ' Joshua C. Bruce. ' .
                        'All rights reserved.'
                )
            )
        )->build();

        return $html;
    }

    private static function cssElement(): Element
    {
        $cssPath  = '/assets/css/main.min.css';
        // $filePath = $contentRoot . $cssPath;
        // TODO: should be last commit of CSS file - another reason to place
        //       content in same folder as rest of project.
        $query = round(microtime(true));

        return Element::link()->omitEndTag()
            ->props('rel stylesheet', "href {$cssPath}?v={$query}");
    }
}
