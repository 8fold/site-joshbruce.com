<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\Site\Content\Markdown;

class OriginalContentNotice
{
    private const COMPONENT_WRAPPER = '{!! platformlink !!}';

    public static function create(PlainTextFile $file): string
    {
        $parts = explode('/', $file->root());
        $parts = array_slice($parts, 0, -1);

        $contentRoot = implode('/', $parts);
        $noticesRoot = $contentRoot . '/notices';

        $fContent = PlainTextFile::at(
            $noticesRoot . '/original.md',
            $noticesRoot
        )->content();

        $matches = [];
        $search  = '/' . self::COMPONENT_WRAPPER . '/';
        if (! preg_match($search, $fContent, $matches)) {
            return '';
        }

        $original = $file->original();
        list($href, $platform) = explode(' ', $original, 2);

        $fContent = preg_replace(
            $search,
            "[{$platform}]({$href})",
            $fContent
        );
        if ($fContent === null) {
            return '';
        }

        return Markdown::markdownConverter()->convert($fContent);
    }
}
