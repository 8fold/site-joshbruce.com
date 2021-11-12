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

        if ($frontMatter->created()) {
            $label      = 'Created';
            $date       = $frontMatter->created();
            $schemaProp = 'dateCreated';

            $times[] = self::timestamp($label, $date, $schemaProp);
        }

        if ($frontMatter->moved()) {
            $label      = 'Moved';
            $date       = $frontMatter->moved();

            $times[] = self::timestamp($label, $date);
        }

        if ($frontMatter->updated()) {
            $label      = 'Updated';
            $date       = $frontMatter->updated();
            $schemaProp = 'dateCreated';

            $times[] = self::timestamp($label, $date, $schemaProp);
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
