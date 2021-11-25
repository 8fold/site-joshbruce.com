<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

// use Symfony\Component\Finder\Finder;
//
// use Eightfold\XMLBuilder\Document;
// use Eightfold\XMLBuilder\Element;
//
// use Eightfold\HTMLBuilder\Element as HtmlElement;
//
// use JoshBruce\Site\File;
// use JoshBruce\Site\FileSystemInterface;
//
// use JoshBruce\Site\Content\Markdown;

class FullNavContent
{
    public static function create(PlainTextFile $file): string
    {
        $finder = Finder::init($file->root())->publishedContent()
            ->getIterator()->depth('>= 1');

        foreach ($finder as $fileInfo) {
            $file = File::from(fileInfo: $fileInfo, $file->root());
            die(var_dump($file));
        }

        die('here');
        // $finder = self::finder($fileSystem)->depth('>= 1');

        $files = self::files($finder, $fileSystem);

        // TODO: full-navigation and legal should be 0 on priority

        $markdownList = '';
        foreach ($files as $path => $file) {
            $path = $file->path(false);

            $title = $file->title();
            $href  = str_replace('/content.md', '', $file->path(false));

            $spacesNeeded = (substr_count($path, '/') * 4) - 8;
            $spaces = str_repeat(' ', $spacesNeeded);
            $listItem = "{$spaces}- [{$title}]({$href}) \n";
            $markdownList .= $listItem;

        }

        return Markdown::markdownConverter()->convert($markdownList);
    }

    /**
     * @return array<string, File>
     */
    private static function files(
        Finder $finder,
        FileSystemInterface $fileSystem,
        bool $all = false
    ): array {
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
            $files[$path] = $file;
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
