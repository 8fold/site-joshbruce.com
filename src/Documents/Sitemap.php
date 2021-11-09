<?php

declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\File;

use JoshBruce\Site\Content\Markdown;

class Sitemap
{
    public static function create(): string
    {
        $finder = FileSystem::finder()->name('content.md')->sortByName()
            ->notContains('redirect:')
            ->notContains('noindex:');

        $markdown = [];
        foreach ($finder as $file) {
            $markdown[] = Markdown::for(
                File::at($file->getPathname())
            );
        }

        $urls = [];
        foreach ($markdown as $m) {
            $urls[] = Element::url(
                Element::loc($m->canonicalUrl())
            );
        }

        return Document::urlset(
            ...$urls
        )->props("xmlns http://www.sitemaps.org/schemas/sitemap/0.9")->build();
    }
}
