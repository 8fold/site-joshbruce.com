<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Content\Markdown;

class FullNavContent
{
    public static function create(
        PlainTextFile $file,
        Environment $environment
    ): string {
        $contentFilename = $environment->contentFilename();

        $finder = Finder::init($file->root(), $contentFilename)
            ->publishedContent()->getIterator()->depth('>= 1');

        $files = [];
        foreach ($finder as $fileInfo) {
            $file = PlainTextFile::from(
                fileInfo: $fileInfo,
                root: $file->root()
            );

            $path = str_replace(
                '/' . $contentFilename,
                '',
                $file->path(false)
            );

            $files[$path] = $file;
        }

        ksort($files);

        $markdownList = '';
        foreach ($files as $f) {
            $path  = $f->path(false);
            $title = $f->title();
            $href  = str_replace(
                '/' . $contentFilename,
                '',
                $path
            );

            if (! str_ends_with($href, '/')) {
                $href = $href . '/';
            }

            // Building a markdown list using separator count to determine depth.
            $spacesNeeded = (substr_count($path, '/') * 4) - 8;
            $spaces = str_repeat(' ', $spacesNeeded);
            $listItem = "{$spaces}- [{$title}]({$href}) \n";

            $markdownList .= $listItem;

        }

        return Markdown::markdownConverter()->convert($markdownList);
    }
}
