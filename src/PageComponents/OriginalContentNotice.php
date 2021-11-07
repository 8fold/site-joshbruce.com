<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\File;
use JoshBruce\Site\FileSystem;

use JoshBruce\Site\Content\Markdown;
use JoshBruce\Site\Content\FrontMatter;

class OriginalContentNotice
{
    public static function create(FrontMatter $frontMatter): string
    {
        $contentRoot = FileSystem::contentRoot();
        $noticesRoot = $contentRoot . '/notices';

        $file = File::at($noticesRoot . '/original.md');
        if ($file->isNotFound()) {
            return '';
        }

        $original = $frontMatter->original();
        list($href, $platform) = explode(' ', $original, 2);

        $body = Markdown::for($file)->body();

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
