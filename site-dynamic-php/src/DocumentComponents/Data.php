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

    private static function listFrom2(
        string $label,
        float $min,
        float $max,
        float $value,
        float|bool $low,
        float|bool $high,
        float|bool $optimum
    ): Element {

    }

    private static function listFrom12(
        string $label,
        float $min,
        float $max,
        float $value
    ): Element {
        $detail = self::detail($min, $max, $value);

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

        return Element::li(
            $label . $parenthetical,
            Element::ul(
                $current,
                $min,
                $max
            )
        )->props('data-icon ' . $detail);
    }

    private static function detail(float $min, float $max, float $value): string
    {
        if ($value > $max) {
            return 'decrease';

        } elseif ($value < $min) {
            return 'increase';

        }
        return 'hold';
    }
}
