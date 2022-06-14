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
            if (count($row) === 4) {
                $listHeadings[] = self::list_from_1_0($row);
            }
        }

        if (count($listHeadings) === 0) {
            return '';

        }
        return Element::ul(...$listHeadings)->props('is data-list')->build();
    }

    private static function list_from_1_0(array $row): Element
    {
        $label   = $row[0];
        $current = $row[3];
        $low     = $row[1];
        $high    = $row[2];

        $detail = '';
        if ($current > $high) {
            $detail = 'decrease';

        } elseif ($current < $low) {
            $detail = 'increase';

        } else {
            $detail = 'hold';

        }

        $label  = Element::span($label)->build();
        $parenthetical = Element::span(' (' . $detail . ')')->build();

        return Element::li(
            $label . $parenthetical,
            Element::ul(
                Element::li(
                    Element::b('current: '),
                    $current
                ),
                Element::li(
                    Element::abbr('min')->props('title minimum'),
                    ': ',
                    $low
                ),
                Element::li(
                    Element::abbr('max')->props('title maximum'),
                    ': ',
                    $high
                )
            )
        )->props('data-icon ' . $detail);

    }
}
