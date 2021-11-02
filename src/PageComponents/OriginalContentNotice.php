<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\Markdown\Markdown;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content;

class OriginalContentNotice
{
    /**
     * @param array<string, mixed> $frontMatter
     */
    public static function create(
        array $frontMatter,
        Markdown $markdownConverter,
        FileSystem $fileSystem
    ): string {
        $file = $fileSystem->with('/messages', 'original.md');
        if (
            array_key_exists('original', $frontMatter) and
            $file->found() and
            $markdown = Content::init($file)->markdown()
        ) {
            list($link, $platform) = explode(' ', $frontMatter['original'], 2);
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
