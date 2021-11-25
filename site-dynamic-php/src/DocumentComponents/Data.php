<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class Data
{
    public static function create(PlainTextFile $file): string
    {
        $data = $file->data();

        $listHeadings = [];
        foreach ($data as $row) {
            $label   = $row[0];
            $current = $row[3];
            $low     = $row[1];
            $high    = $row[2];

            $detail = 'hold';
            if ($current > $high) {
                $detail = 'decrease';

            } elseif ($current < $low) {
                $detail = 'increase';

            }

            $listHeadings[] = Element::li(
                $label . " ({$detail})",
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
            );
        }

        if (count($listHeadings) === 0) {
            return '';

        }
        return Element::ul(...$listHeadings)->build();
    }
}
