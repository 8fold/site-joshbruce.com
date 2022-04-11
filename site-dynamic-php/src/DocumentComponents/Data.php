<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFileFromAlias;

class Data
{
    public static function create(
        PlainTextFile|PlainTextFileFromAlias $file
    ): string {
        $data = $file->data();

        $listHeadings = [];
        foreach ($data as $row) {
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

            $listHeadings[] = Element::li(
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

        if (count($listHeadings) === 0) {
            return '';

        }
        return Element::ul(...$listHeadings)->props('is data-list')->build();
    }
}
