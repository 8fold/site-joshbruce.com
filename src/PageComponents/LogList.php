<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use JoshBruce\Site\FileSystemInterface;
use JoshBruce\Site\File;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\Content\Markdown;

class LogList
{
    public static function create(
        File $file,
        FileSystemInterface $fileSystem
    ): string {
        $fileSubfolders = $file->children(filesNamed: 'content.md');
        if (count($fileSubfolders) === 0) {
            return '';
        }

        krsort($fileSubfolders);
        $logLinks = [];
        foreach ($fileSubfolders as $key => $file) {
            if (! str_starts_with(strval($key), '_') and $file->found()) {
                $markdown = Markdown::for($file, $fileSystem);

                $linkPath = str_replace(
                    '/content.md',
                    '',
                    $file->path(full: false)
                );

                $logLinks[] = Element::li(
                    Element::a(
                        $file->title()
                    )->props('href ' . $linkPath)
                );
            }
        }
        return Element::ul(...$logLinks)->build();
    }
}
