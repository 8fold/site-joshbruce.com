<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Documents;

// use Symfony\Component\Finder\Finder;
//
use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
//
// use Eightfold\HTMLBuilder\Element as HtmlElement;
//
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;
use JoshBruce\SiteDynamic\FileSystem\File;
//
// use JoshBruce\Site\Content\Markdown;

use JoshBruce\SiteDynamic\FileSystem\Finder;

class Sitemap
{
    public static function create(PlainTextFile $file): string
    {
        $finder = Finder::init($file->root())->publishedContent()
            ->getIterator()->depth('>= 1');

        $files = [];
        foreach ($finder as $fileInfo) {
            $f = PlainTextFile::from(
                fileInfo: $fileInfo,
                root: $file->root()
            );

            $path = str_replace(
                '/' . $_SERVER['CONTENT_FILENAME'],
                '',
                $f->path(false)
            );

            $files[$path] = $f;
        }

        $urls = [];
        foreach ($files as $f) {
            $path = strval(str_replace('/content.md', '', $f->path()));
            $frontMatter = $f->frontMatter();
            $date = '';
            if ($f->hasMetadata('updated')) {
                $date = $f->updated('Y-m-d');

            } elseif ($f->hasMetadata('created')) {
                $date = $f->created('Y-m-d');

            }

            if (is_string($date) and strlen($date) === 0) {
                continue;

            }

            $priority = 0.5;
            if (
                str_starts_with(
                    $f->path(false),
                    '/finances/building-wealth-paycheck-to-paycheck/'
                )
            ) {
                $priority = 0.0;

            } elseif (str_starts_with($f->path(false), '/finances')) {
                $priority = 0.1;

            }

            $urls[$path] = Element::url(
                Element::loc(
                    File::at($path, $f->root())->canonicalUrl()
                ),
                Element::lastmod($date),
                Element::priority($priority)
            );
        }

        ksort($urls);

        return Document::urlset(
            ...$urls
        )->props("xmlns http://www.sitemaps.org/schemas/sitemap/0.9")->build();
    }
}
