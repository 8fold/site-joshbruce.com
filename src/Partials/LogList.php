<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Amos\Site;

use Eightfold\HTMLBuilder\Element;

class LogList implements Buildable
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
        $path = $this->site()->publicRoot() . $this->site()->requestPath();
        if (is_dir($path) === false) {
            return '';
        }

        $contents = scandir($path);
        if ($contents === false) {
            return '';
        }

        $links = [];
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

            $meta = $this->site()->meta($href);
            if (is_object($meta) and property_exists($meta, 'title')) {
                $index = intval($content);
                $links[$index] = Element::li(
                    Element::a($meta->title)->props('href ' . $href)
                );
            }
        }

        krsort($links);

        return Element::ul(...$links)->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
