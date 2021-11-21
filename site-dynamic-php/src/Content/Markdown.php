<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Content;

use Eightfold\Markdown\Markdown as MarkdownConverter;

class Markdown
{
    private static MarkdownConverter $markdownConverter;

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
