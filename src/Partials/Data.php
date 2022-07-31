<?php

declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class Data
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

    public function build(): string
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
                $min     = floatval($row->min);
                $max     = floatval($row->max);
                $value   = floatval($row->value);
                $low     = floatval($row->low);
                $high    = floatval($row->high);
                $optimum = floatval($row->optimum);

                $listHeadings[] = self::listFrom12($label, $min, $max, $value);

            } elseif (
                property_exists($row, 'label') and
                property_exists($row, 'min') and
                property_exists($row, 'max') and
                property_exists($row, 'value')
            ) {
                $label = $row->label;
                $min   = floatval($row->min);
                $max   = floatval($row->max);
                $value = floatval($row->value);

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
        return Element::ul(...$listHeadings)->props('is data-list')->build();
    }

    public function __toString(): string
    {
        return $this->build();
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
