<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Carbon\Carbon;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\Content\FrontMatter;

class DateBlock
{
    public static function create(FrontMatter $frontMatter): string
    {
        $times = [];
        $dateblock = $frontMatter->dateblock();
        foreach ($dateblock as $date) {
            list($d, $label) = explode(' ', $date, 2);
            $schemaProp = '';
            if (str_starts_with($label, 'Created')) {
                $schemaProp = 'dateCreated';

            } elseif (str_starts_with($label, 'Updated')) {
                $schemaProp = 'dateModified';

            }
            $times[] = self::timestamp($label, intval($d), $schemaProp);
        }

        if (count($times) === 0) {
            return '';
        }
        return Element::div(...$times)->props('is dateblock')->build();
    }

    private static function timestamp(
        string $label,
        int|false $date = false,
        string $schemaProp = ''
    ): Element|string {
        if (! $date) {
            return '';
        }

        if ($carbon = Carbon::createFromFormat('Ymd', strval($date))) {
            $time = Element::time($carbon->toFormattedDateString())
                ->props(
                    (strlen($schemaProp) > 0) ? "property {$schemaProp}" : '',
                    'content ' . $carbon->format('Y-m-d')
                )->build();
            return Element::p("{$label}: {$time}");
        }
        return '';
    }
}
