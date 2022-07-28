<?php
declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Documents;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class Sitemap
{
    private const DATE_FORMAT = 'Y-m-d';

    public static function create(
        PlainTextFile $file,
        Environment $environment
    ): string {
        $root = $file->root();

        $finder = Finder::init(
            $root,
            $environment->contentFilename()
        )->publishedContent()->getIterator()->depth('>= 1');

        $urls = [];
        foreach ($finder as $fileInfo) {
            $f = PlainTextFile::from(fileInfo: $fileInfo, root: $root);

            $lastmod = $f->updated(self::DATE_FORMAT);
            if (! $lastmod) {
                $lastmod = $f->created(self::DATE_FORMAT);
            }

            // No mod or creation date, no inclusion in sitemap.
            if (! $lastmod) {
                continue;
            }

            $path = $f->path(full: false, omitFilename: true);

            $onePriorityEssays = '/essays-and-editorials/';
            $onePriorityBooks  = '/books/';
            $pointSevenFive    = '/experiences/';
            $pointOnePriority  = '/experiences/finances';
            $zeroPriority      = '/experiences/finances/paycheck-to-paycheck/';

            $priority = 0.5;
            if (
                str_starts_with($path, $onePriorityBooks) or
                str_starts_with($path, $onePriorityEssays)
            ) {
                $priority = 1.0;

            } elseif (str_starts_with($path, $pointOnePriority)) {
                $priority = 0.1;

            } elseif (str_starts_with($path, $zeroPriority)) {
                $priority = 0.0;

            } elseif (str_starts_with($path, $pointSevenFive)) {
                $priority = 0.75;

            }

            $urls[$path] = Element::url(
                Element::loc($f->canonicalUrl($environment->appUrl()) . '/'),
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
