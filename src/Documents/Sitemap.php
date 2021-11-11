<?php

declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Symfony\Component\Finder\Finder;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystemInterface;
use JoshBruce\Site\File;
use JoshBruce\Site\Content\Markdown;

class Sitemap
{
    public static function create(FileSystemInterface $fileSystem): string
    {
        $finder = self::finder($fileSystem);

        $files = self::files($finder, $fileSystem, true);

        $urls = [];
        foreach ($files as $file) {
            $path = str_replace('/content.md', '', $file->path());
            $urls[$path] = Element::url(
                Element::loc(
                    File::at($path, $fileSystem)->canonicalUrl()
                )
            );
        }
        ksort($urls);

        return Document::urlset(
            ...$urls
        )->props("xmlns http://www.sitemaps.org/schemas/sitemap/0.9")->build();
    }

    public static function list(FileSystemInterface $fileSystem): string
    {
        $finder = self::finder($fileSystem)->depth('>= 1');

        $files = self::files($finder, $fileSystem);

        // TODO: full-navigation and legal should be 0 on priority

        $markdownList = '';
        foreach ($files as $path => $file) {
            $path = $file->path(false);

            $title = Markdown::for($file, $fileSystem)->frontMatter()->title();
            $href  = str_replace('/content.md', '', $file->path(false));

            $spacesNeeded = (substr_count($path, '/') * 4) - 8;
            $spaces = str_repeat(' ', $spacesNeeded);
            $listItem = "{$spaces}- [{$title}]({$href}) \n";
            $markdownList .= $listItem;

        }

        return Markdown::markdownConverter()->convert($markdownList);
    }

    private static function files(
        Finder $finder,
        FileSystemInterface $fileSystem,
        bool $all = false
    ): array
    {
        $files = [];
        foreach ($finder as $file) {
            $path = str_replace('/content.md', '', $file->getPathname());
            if (
                ! $all and
                str_contains($path, '/full-navigation') and
                str_contains($path, '/legal')
            ) {
                continue;
            }

            $file = File::at($file->getPathname(), $fileSystem);
            $files[$path] = $file; // $file->canonicalUrl();
        }

        ksort($files);

        return $files;
    }

    private static function finder(FileSystemInterface $fileSystem): Finder
    {
        return $fileSystem->publishedContentFinder()->sortByName()
            ->notContains('redirect:')
            ->notContains('noindex:');
    }

}
