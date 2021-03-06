<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Content\Markdown;

class LogList
{
    public static function create(
        PlainTextFile $file,
        Environment $environment
    ): string {
        $path = $file->path(omitFilename: true);

        $finder = Finder::init(
            $path,
            $environment->contentFilename()
        )->publishedContent();
        if (count($finder) === 0) {
            return '';
        }

        $logLinks = [];
        foreach ($finder as $fileInfo) {
            if ($fileInfo->getRealPath() === $file->path()) {
                continue;
            }

            $f = PlainTextFile::from($fileInfo, $file->root());

            $title = $f->title();
            $href  = $f->canonicalUrl($environment->appUrl());

            if (! str_ends_with($href, '/')) {
                $href = $href . '/';
            }

            $key = $f->path(full: false, omitFilename: true);

            $logLinks[$key] = Element::li(
                Element::a($title)->props("href {$href}")
            );
        }

        krsort($logLinks);

        return Element::ul(...$logLinks)->build();
    }
}
