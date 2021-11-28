<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\Content\Markdown;

class LogList
{
    public static function create(PlainTextFile $file): string
    {
        $finder = Finder::init($file->path(omitFilename: true))
            ->publishedContent();
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
            $href  = $f->canonicalUrl();

            $key = $f->path(full: false, omitFilename: true);

            $logLinks[$key] = Element::li(
                Element::a($title)->props("href {$href}")
            );
        }

        krsort($logLinks);

        return Element::ul(...$logLinks)->build();
    }
}
