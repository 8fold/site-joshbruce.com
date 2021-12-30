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
            $change = $current - $previous;

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
                        $change
                    ),
                    Element::li(
                        'start',
                        ': ',
                        $start
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
