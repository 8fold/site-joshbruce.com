<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;

use JoshBruce\Site\Content\FrontMatter;

class LogList
{
    /**
     * @param FileSystem[] $fileSubfolders
     */
    public static function create(
        array $fileSubfolders
    ): string {
        if (count($fileSubfolders) === 0) {
            return '';
        }

        krsort($fileSubfolders);
        $logLinks = [];
        foreach ($fileSubfolders as $key => $f) {
            if (! str_starts_with(strval($key), '_') and $f->found()) {
                $markdown = Markdown::init($f);

                $logLinks[] = HtmlElement::li(
                    HtmlElement::a(
                        $markdown->frontMatter()->title() // ['title']
                    )->props('href ' . $f->folderPath(full: false))
                );
            }
        }
        return HtmlElement::ul(...$logLinks)->build();
    }
}
