<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\File;

use JoshBruce\Site\Content\Markdown;

class Navigation
{
    public static function create(string $fileName): string
    {
        $contentRoot    = FileSystem::contentRoot();
        $navigationPath = $contentRoot . '/navigation';
        $filePath       = $navigationPath . '/' . $fileName;
        $file           = File::at($filePath);
        if ($file->isNotFound()) {
            return '';
        }

        $html = Markdown::for($file)->html();

        return Element::nav($html)->props('id main-nav')->build();
    }
}
