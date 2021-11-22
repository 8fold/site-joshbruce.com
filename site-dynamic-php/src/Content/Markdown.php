<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Content;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\SiteDynamic\FileSystem\File;

use JoshBruce\Site\DocumentComponents\Data;
use JoshBruce\Site\DocumentComponents\DateBlock;
use JoshBruce\Site\DocumentComponents\LogList;
use JoshBruce\Site\DocumentComponents\OriginalContentNotice;

class Markdown
{
    private static MarkdownConverter $markdownConverter;

    private const DOCUMENTS = [

    ];

    private const COMPONENTS = [
        'data'      => Data::class,
        'dateblock' => DateBlock::class,
        'full-nav'  => Sitemap::class,
        'loglist'   => LogList::class,
        'original'  => OriginalContentNotice::class
    ];

    public static function markdownConverter(): MarkdownConverter
    {
        if (! isset(self::$markdownConverter)) {
            self::$markdownConverter = MarkdownConverter::create()
                ->minified() // can't be minified due to code blocks
                ->smartPunctuation()
                ->withConfig(['html_input' => 'allow'])
                ->descriptionLists()
                ->attributes()
                ->abbreviations()
                ->externalLinks([
                    'open_in_new_window' => true,
                    'internal_hosts' => 'joshbruce.com'
                ])->accessibleHeadingPermalinks(
                    [
                        'min_heading_level' => 2,
                        'symbol' => '＃'
                    ],
                );
        }
        return self::$markdownConverter;
    }
}
