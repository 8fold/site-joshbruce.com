<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;
use JoshBruce\Site\Content\FrontMatter;

class OriginalContentNotice
{
    public static function create(
        FrontMatter $frontMatter,
        FileSystem $fileSystem
    ): string {
        $file = $fileSystem->with('/messages', 'original.md');
        if (
            $frontMatter->hasMember('original') and
            $file->found() and
            $markdown = Markdown::init($file)->markdown()
        ) {
            list($link, $platform) = explode(' ', $frontMatter->original(), 2);
            $originalLink = "[{$platform}]({$link})";
            $markdown = str_replace(
                '{{platform link}}',
                $originalLink,
                $markdown
            );

            return $markdown;
        }
        return '';
    }
}
