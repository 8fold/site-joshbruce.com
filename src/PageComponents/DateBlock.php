<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Carbon\Carbon;

use Eightfold\HTMLBuilder\Element as HtmlElement;

class DateBlock
{
    /**
     * @param array<string, mixed> $frontMatter
     */
    public static function create(array $frontMatter): string
    {
        $created = self::timestamp(
            $frontMatter,
            'created',
            'Created on',
            'dateCreated'
        );

        $moved = self::timestamp($frontMatter, 'moved', 'Moved on');

        $updated = self::timestamp(
            $frontMatter,
            'updated',
            'Updated on',
            'dateModified'
        );

        if (empty($updated) and empty($moved) and empty($created)) {
            return '';
        }
        return HtmlElement::div($created, $moved, $updated)
            ->props('is dateblock')->build();
    }

    private static function timestamp(
        array $frontMatter,
        string $key,
        string $label,
        string $schemaProp = ''
    ): HtmlElement|string {
        if (
            array_key_exists($key, $frontMatter) and
            $carbon = Carbon::createFromFormat('Ymd', $frontMatter[$key])
        ) {
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
