<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Carbon\Carbon;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\File;

class DateBlock
{
    public static function create(File $file): string
    {
        $times = [];

        if ($file->created()) {
            $label      = 'Created';
            $date       = $file->created();
            $schemaProp = 'dateCreated';

            $times[] = self::timestamp($label, $date, $schemaProp);
        }

        if ($file->moved()) {
            $label      = 'Moved';
            $date       = $file->moved();

            $times[] = self::timestamp($label, $date);
        }

        if ($file->updated()) {
            $label      = 'Updated';
            $date       = $file->updated();
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
        string|int|false $date = false,
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
