<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Stringable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class FiExperiments implements Stringable
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
