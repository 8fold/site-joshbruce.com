<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Carbon\Carbon;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\Content\FrontMatter;

class DateBlock
{
    public static function create(FrontMatter $frontMatter): string
    {
        $created = self::timestamp(
            'Created on',
            $frontMatter->created(),
            'dateCreated'
        );

        $moved = self::timestamp('Moved on', $frontMatter->moved());

        $updated = self::timestamp(
            'Updated on',
            $frontMatter->updated(),
            'dateModified'
        );

        if (empty($updated) and empty($moved) and empty($created)) {
            return '';
        }
        return HtmlElement::div($created, $moved, $updated)
            ->props('is dateblock')->build();
    }

    private static function timestamp(
        string $label,
        int|false $date = false,
        string $schemaProp = ''
    ): HtmlElement|string {
        if (! $date) {
            return '';
        }

        if ($carbon = Carbon::createFromFormat('Ymd', strval($date))) {
            $time = HtmlElement::time($carbon->toFormattedDateString())
                ->props(
                    (strlen($schemaProp) > 0) ? "property {$schemaProp}" : '',
                    'content ' . $carbon->format('Y-m-d')
                )->build();
            return HtmlElement::p("{$label}: {$time}");
        }
        return '';
    }
}
