<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use DateTime;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFileFromAlias;

class DateBlock
{
    public static function create(
        PlainTextFile|PlainTextFileFromAlias $file
    ): string {
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
            $schemaProp = 'dateModified';

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

        // TODO: Should be a way to abstract this - see PlainTextFile
        if ($date = DateTime::createFromFormat('Ymd', strval($date))) {
            $time = Element::time($date->format('M j, Y'))
                ->props(
                    (strlen($schemaProp) > 0) ? "property {$schemaProp}" : '',
                    'content ' . $date->format('Y-m-d')
                )->build();
            return Element::p("{$label}: {$time}");
        }
        return '';
    }
}
