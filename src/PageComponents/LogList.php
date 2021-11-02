<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;

class LogList
{
    /**
     * @param array<string, mixed> $frontMatter
     */
    public static function create(array $frontMatter, FileSystem $file): string
    {
        if (
            array_key_exists('type', $frontMatter) and
            $frontMatter['type'] === 'log'
        ) {
            $contents = $file->subfolders('content.md');
            krsort($contents);
            $logLinks = [];
            foreach ($contents as $key => $f) {
                if (! str_starts_with(strval($key), '_') and $f->found()) {
                    $markdown = Markdown::init($f);

                    $logLinks[] = HtmlElement::li(
                        HtmlElement::a(
                            $markdown->frontMatter()['title']
                        )->props('href ' . $f->folderPath(full: false))
                    );
                }
            }
            return HtmlElement::ul(...$logLinks)->build();
        }
        return '';
    }
}
