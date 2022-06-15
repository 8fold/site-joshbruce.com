<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class Data
{
    public static function create(
        PlainTextFile $file
    ): string {
        $data = $file->data();

        $listHeadings = [];
        foreach ($data as $row) {
            if (count($row) === 4 and array_key_exists(0, $row)) {
                $label = strval($row[0]);
                $min   = floatval($row[1]);
                $max   = floatval($row[2]);
                $value = floatval($row[3]);
                $listHeadings[] = self::listFrom12($label, $min, $max, $value);

            } elseif (count($row) === 4 and array_key_exists('label', $row)) {
                $label = strval($row['label']);
                $min   = floatval($row['min']);
                $max   = floatval($row['max']);
                $value = floatval($row['value']);
                $listHeadings[] = self::listFrom12($label, $min, $max, $value);

            } elseif (array_key_exists('low', $row)) {
                $label   = strval($row['label']);
                $min     = floatval($row['min']);
                $max     = floatval($row['max']);
                $value   = floatval($row['value']);
                $low     = floatval($row['low']);
                $high    = floatval($row['high']);
                $optimum = floatval($row['optimum']);
                $listHeadings[] = self::listFrom12(
                    $label,
                    $min,
                    $max,
                    $value,
                    $low,
                    $high,
                    $optimum
                );
            }
        }

        if (count($listHeadings) === 0) {
            return '';

        }
        return Element::ul(...$listHeadings)->props('is data-list')->build();
    }

    private static function listFrom12(
        string $label,
        float $min,
        float $max,
        float $value,
        float|bool $low = false,
        float|bool $high = false,
        float|bool $optimum = false
    ): Element {
        $detail = '';
        if ($value > $max) {
            $detail = 'decrease';

        } elseif ($value < $min) {
            $detail = 'increase';

        } else {
            $detail = 'hold';

        }

        $label  = Element::span($label)->build();
        $parenthetical = Element::span(' (' . $detail . ')')->build();

        $current = Element::li(
            Element::b('current: '),
            $value
        );

        $min = Element::li(
            Element::abbr('min')->props('title minimum'),
            ': ',
            $min
        );

        $max = Element::li(
            Element::abbr('max')->props('title maximum'),
            ': ',
            $max
        );

        if ($low !== false and $high !== false and $optimum !== false) {
            $low = Element::li(
                Element::b('low: '),
                $low
            );

            $high = Element::li(
                Element::b('high: '),
                $high
            );

            $optimum = Element::li(
                Element::b('optimum: '),
                $optimum
            );
        }

        return Element::li(
            $label . $parenthetical,
            Element::ul(
                $current,
                $min,
                $max,
                $low,
                $high,
                $optimum
            )
        )->props('data-icon ' . $detail);
    }
}
