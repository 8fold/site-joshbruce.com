<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\ObjectsFromJson\PublicObject;

class Data implements PartialInterface
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

        $site = $extras['site'];
        $request_path = $extras['request_path'];

        $data = PublicObject::inRoot(
            $site->contentRoot(),
            'data.json',
            $request_path
        );

        if ($data->notFound()) {
            return '';
        }

        $data = $data->data();

        $listHeadings = [];
        foreach ($data as $row) {
            if (
                property_exists($row, 'label') and
                property_exists($row, 'min') and
                property_exists($row, 'max') and
                property_exists($row, 'value') and
                property_exists($row, 'low') and
                property_exists($row, 'high') and
                property_exists($row, 'optimum')
            ) {
                $label   = $row->label;
                $min     = $row->min;
                $max     = $row->max;
                $value   = $row->value;
                $low     = $row->low;
                $high    = $row->high;
                $optimum = $row->optimum;

                $listHeadings[] = self::listFrom12($label, $min, $max, $value);

            } elseif (
                property_exists($row, 'label') and
                property_exists($row, 'min') and
                property_exists($row, 'max') and
                property_exists($row, 'value')
            ) {
                $label = $row->label;
                $min   = $row->min;
                $max   = $row->max;
                $value = $row->value;

                $listHeadings[] = self::listFrom12(
                    $label,
                    $min,
                    $max,
                    $value
                );
            }
        }

        if (count($listHeadings) === 0) {
            return '';

        }
        return (string) Element::ul(...$listHeadings)->props('is data-list');
    }

    private static function listFrom12(
        string $label,
        string $min,
        string $max,
        string $value
    ): Element {
        $detail = self::detail(floatval($min), floatval($max), floatval($value));

        $label  = (string) Element::span($label);
        $parenthetical = (string) Element::span(' (' . $detail . ')');

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
