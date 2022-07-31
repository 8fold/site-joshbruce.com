<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class FiExperiments implements Buildable
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
            named: '/fi-experiments.json',
            at: $this->site()->requestPath()
        );
        if ($meta === false) {
            return '';
        }
        $data = $meta->experiments;

        $listHeadings = [];
        foreach ($data as $row) {
            if (
                property_exists($row, 'label') and
                property_exists($row, 'current') and
                property_exists($row, 'previous') and
                property_exists($row, 'start')
            ) {
                $label    = $row->label;
                $current  = floatval($row->current);
                $previous = floatval($row->previous);
                $start    = floatval($row->start);

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
        return Element::ul(...$listHeadings)->build();
    }

    public function __toString(): string
    {
        return $this->build();
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
