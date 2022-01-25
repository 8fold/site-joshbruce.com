<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class FiExperiments
{
    public static function create(PlainTextFile $file): string
    {
        $data = $file->fiExperiments();

        $listHeadings = [];
        foreach ($data as $row) {
            list($label, $current, $previous, $start) = $row;
            $previousChange = self::calculateChangeBetween($current, $previous);
            $startChange    = self::calculateChangeBetween($current, $start);

            $listHeadings[] = Element::li(
                'Mark ' . $label,
                Element::ul(
                    Element::li(
                        Element::b('current: '),
                        $current
                    ),
                    Element::li(
                        'previous',
                        ': ',
                        $previous
                    ),
                    Element::li(
                        'change',
                        ': ',
                        $previousChange,
                        ' percent'
                    ),
                    Element::li(
                        'since started tracking',
                        ': ',
                        $startChange,
                        ' percent'
                    )
                )
            );
        }

        if (count($listHeadings) === 0) {
            return '';

        }
        return Element::ul(...$listHeadings)->build();
    }

    private static function calculateChangeBetween(
        float $first,
        float $second
    ): float {
        $difference = $first - $second;
        $decimal    = $difference / $second;
        $percent    = $decimal * 100;

        return round($percent, 2);
    }
}
