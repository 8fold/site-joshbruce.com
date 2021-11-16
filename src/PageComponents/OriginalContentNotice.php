<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\File;
use JoshBruce\Site\FileSystemInterface;

use JoshBruce\Site\Content\Markdown;

class OriginalContentNotice
{
    public static function create(
        File $file,
        FileSystemInterface $fileSystem
    ): string {
        $contentRoot = $fileSystem->contentRoot();
        $noticesRoot = $contentRoot . '/notices';

        $f = File::at($noticesRoot . '/original.md', $fileSystem);
        if ($f->isNotFound()) {
            return '';
        }

        $original = $file->original();
        list($href, $platform) = explode(' ', $original, 2);

        $body = Markdown::for($file, $fileSystem)->body();

        $matches = [];
        $search  = '/{!!platformlink!!}/';
        if (! preg_match($search, $body, $matches)) {
            return '';
        }

        $body = preg_replace($search, "[{$platform}]({$href})", $body);
        if ($body === null) {
            return '';
        }

        return Markdown::markdownConverter()->convert($body);
    }
}
