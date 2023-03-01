<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Stringable;

use Eightfold\Amos\Site;

use Eightfold\HTMLBuilder\Element;

class PaycheckLogList implements Stringable
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
        $path = $this->site()->publicRoot() . $this->site()->requestPath();
        if (is_dir($path) === false) {
            return '';
        }

        $contents = scandir($path);
        if ($contents === false) {
            return '';
        }

        $currentYear = [];
        $years = [];
        foreach ($contents as $content) {
            if (
                $content === '.' or
                $content === '..' or
                $content === '.DS_Store' or
                str_contains($content, '.')
            ) {
                continue;
            }

            $href = $this->site()->requestPath() . '/' . $content;
            $item = $this->listItem($href);
            if ($item === false) {
                continue;
            }

            $year = date('Y');
            if (str_starts_with($content, $year)) {
                $currentYear[$content] = $item;
                continue;
            }

            $year = substr($content, 0, 4);
            $links[$year][$content] = $item;
        }

        $return = (string) Element::ul(...$currentYear);

        krsort($links);

        $pastYears = [];
        foreach($links as $year => $items) {
            krsort($items);
            $return .= (string) Element::details(
                Element::summary(strval($year)),
                Element::ul(...$items)
            );
        }

        return $return;
    }

    private function listItem(string $href): Element|false
    {
        $meta = $this->site()->meta($href);
        if (is_object($meta) and property_exists($meta, 'title')) {
            return Element::li(
                Element::a($meta->title)->props('href ' . $href)
            );
        }
        return false;
    }
}
