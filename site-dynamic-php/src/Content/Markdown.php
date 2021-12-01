<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Content;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\DocumentComponents\Data;
use JoshBruce\SiteDynamic\DocumentComponents\DateBlock;
use JoshBruce\SiteDynamic\DocumentComponents\FullNavContent;
use JoshBruce\SiteDynamic\DocumentComponents\LogList;
use JoshBruce\SiteDynamic\DocumentComponents\OriginalContentNotice;

class Markdown
{
    private static MarkdownConverter $markdownConverter;

    private static MarkdownConverter $titleConverter;

    private const COMPONENTS = [
        'data'      => Data::class,
        'dateblock' => DateBlock::class,
        'full-nav'  => FullNavContent::class,
        'loglist'   => LogList::class,
        'original'  => OriginalContentNotice::class
    ];

    private const COMPONENT_WRAPPER = '{!!(.*)!!}';

    public static function markdownConverter(): MarkdownConverter
    {
        if (! isset(self::$markdownConverter)) {
            self::$markdownConverter = MarkdownConverter::create()
                ->withConfig(
                    [
                        'html_input' => 'allow'
                    ]
                )->minified()
                ->smartPunctuation()
                ->descriptionLists()
                // ->attributes()
                ->abbreviations()
                ->externalLinks(
                    [
                        'open_in_new_window' => true,
                        'internal_hosts' => 'joshbruce.com'
                    ]
                )->accessibleHeadingPermalinks(
                    [
                        'min_heading_level' => 2,
                        'symbol' => '＃'
                    ],
                );
        }
        return self::$markdownConverter;
    }

    public static function titleConverter(): MarkdownConverter
    {
        if (! isset(self::$titleConverter)) {
            self::$titleConverter = MarkdownConverter::create()
                ->smartPunctuation();
        }
        return self::$titleConverter;
    }

    public static function processPartials(
        string $body,
        PlainTextFile $file,
        Environment $environment
    ): string {
        $partials = [];
        if (
            preg_match_all(
                '/' . self::COMPONENT_WRAPPER . '/',
                $body,
                $partials // Populates $partials
            )
        ) {
            $replacements = $partials[0];
            $templates    = $partials[1];

            for ($i = 0; $i < count($replacements); $i++) {
                $partialKey = trim($templates[$i]);
                if (! array_key_exists($partialKey, self::COMPONENTS)) {
                    continue;
                }

                $template = self::COMPONENTS[$partialKey];

                $body = str_replace(
                    $replacements[$i],
                    $template::create($file, $environment),
                    $body
                );
            }
        }
        return $body;
    }
}
