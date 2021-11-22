<?php

declare(strict_types=1);

namespace JoshBruce\Site\DocumentComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\FileSystemInterface;
use JoshBruce\Site\File;

use JoshBruce\Site\Content\Markdown;

class Navigation
{
    public static function create(
        string $fileName,
        FileSystemInterface $fileSystem
    ): string {
        $contentRoot    = $fileSystem->contentRoot();
        $navigationPath = $contentRoot . '/navigation';
        $filePath       = $navigationPath . '/' . $fileName;
        $file           = File::at($filePath, $fileSystem);
        if ($file->isNotFound()) {
            return '';
        }

        $html = Markdown::for($file, $fileSystem)->html();

        return Element::nav($html)->props('id main-nav')->build();
    }
}
