<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Stringable;
// use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class Data implements Stringable // Buildable
{
    public static function create(Site $site): self
    {
        return new self($site);
    }

    final private function __construct(private Site $site)
    {
    }

    private function site(): Site
    {
        return $this->site;
    }

    public function __toString(): string
    {
        $meta = $this->site()->decodedJsonFile(
            named: '/data.json',
            at: $this->site()->requestPath()
        );
        if ($meta === false) {
            return '';
        }
        $data = $meta->data;

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
