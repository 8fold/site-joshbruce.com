<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Content;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\DocumentComponents\Data;
use JoshBruce\SiteDynamic\DocumentComponents\DateBlock;
use JoshBruce\SiteDynamic\DocumentComponents\FullNavContent;
use JoshBruce\SiteDynamic\DocumentComponents\LogList;
use JoshBruce\SiteDynamic\DocumentComponents\OriginalContentNotice;

class Markdown
{
    private static MarkdownConverter $markdownConverter;

    private const DOCUMENTS = [

    ];

    private const COMPONENTS = [
        'data'      => Data::class,
        'dateblock' => DateBlock::class,
        'full-nav'  => FullNavContent::class, // TODO: finish implementing templates
        'loglist'   => LogList::class,
        'original'  => OriginalContentNotice::class
    ];

    private const COMPONENT_WRAPPER = '{!!(.*)!!}';

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

    public static function processPartials(
        string $body,
        PlainTextFile $file
    ): string {
        // $body = $this->body();

        $partials = [];
        if (
            preg_match_all(
                '/' . self::COMPONENT_WRAPPER . '/',
                $body,
                $partials
            )
        ) {
            $replacements = $partials[0];
            $templates    = $partials[1];

            for ($i = 0; $i < count($replacements); $i++) {
                $partialKey = trim($templates[$i]);
                if (! array_key_exists($partialKey, self::COMPONENTS)) {
                    continue;
                }

                $b = '';
                $template = self::COMPONENTS[$partialKey];
                if (
                    $partialKey === 'data' or
                    $partialKey === 'dateblock' or
                    $partialKey === 'full-nav' or
                    $partialKey === 'loglist'
                ) {
                    $b = $template::create($file);

                } elseif ($partialKey === 'loglist') {
                    $b = $template::create($this->file(), $this->fileSystem());

                } else {
                    $b = $template::create(
                        $this->file(),
                        $this->fileSystem()
                    );

                }
                $body = str_replace($replacements[$i], $b, $body);
            }
        }
        return self::markdownConverter()->convert($body);
    }

}
