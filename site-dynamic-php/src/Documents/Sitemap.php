<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Documents;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class Sitemap
{
    private const DATE_FORMAT = 'Y-m-d';

    public static function create(PlainTextFile $file): string
    {
        $root = $file->root();

        $finder = Finder::init($root)->publishedContent()->getIterator()
            ->depth('>= 1');

        $urls = [];
        foreach ($finder as $fileInfo) {
            $f = PlainTextFile::from(fileInfo: $fileInfo, root: $root);

            $lastmod = $f->updated(self::DATE_FORMAT);
            if (is_bool($lastmod) and ! $lastmod) {
                $lastmod = $f->created(self::DATE_FORMAT);
            }

            // No mod or creation date, no inclusion in sitemap.
            if (is_bool($lastmod) and ! $lastmod) {
                continue;

            }

            $path = $f->path(full: false, omitFilename: true);

            $zeroPriority = '/finances/building-wealth-paycheck-to-paycheck/';
            $onePriority  = '/finances';

            $priority = 0.5;
            if (str_starts_with($path, $zeroPriority)) {
                $priority = 0.0;

            } elseif (str_starts_with($path, $onePriority)) {
                $priority = 0.1;

            }

            $urls[$path] = Element::url(
                Element::loc($f->canonicalUrl()),
                Element::lastmod($lastmod),
                Element::priority($priority)
            );
        }

        ksort($urls);

        return Document::urlset(
            ...$urls
        )->props("xmlns http://www.sitemaps.org/schemas/sitemap/0.9")->build();
    }
}
