<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\ObjectsFromJson\PublicObject;

class FiExperiments implements PartialInterface
{
    public function __invoke(
        PartialInput $input,
        array $extras = []
    ): string {
        if (
            array_key_exists('site', $extras) === false or
            array_key_exists('request_path', $extras) === false
        ) {
            return '';
        }

        $site         = $extras['site'];
        $request_path = $extras['request_path'];

        $meta = PublicObject::inRoot(
            $site->contentRoot(),
            'fi-experiments.json',
            $request_path
        );
        if (
            $meta->notFound() or
            $meta->hasProperty('experiments') === false
        ) {
            return '';
        }

        $data = $meta->experiments();

        $listHeadings = [];
        foreach ($data as $row) {
            if (
                property_exists($row, 'label') and
                property_exists($row, 'current') and
                property_exists($row, 'previous') and
                property_exists($row, 'start')
            ) {
                $label    = $row->label;
                $current  = $row->current;
                $previous = $row->previous;
                $start    = $row->start;

                $previousChange = self::calculateChangeBetween($current, $previous);
                $startChange    = self::calculateChangeBetween($current, $start);

                $listHeadings[] = Element::li(
                    $label,
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
        }

        if (count($listHeadings) === 0) {
            return '';

        }
        return (string) Element::ul(...$listHeadings);
    }

    private static function calculateChangeBetween(
        string $first,
        string $second
    ): string {
        $first = floatval($first);
        $second = floatval($second);

        $difference = $first - $second;
        $decimal    = $difference / $second;
        $percent    = $decimal * 100;

        $result = round($percent, 2);

        return strval($result);
    }
}
