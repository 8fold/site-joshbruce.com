<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Stringable;
// use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class ArticleList implements Stringable // Buildable
{
    public static function create(Site $site): self
    {
        return new self($site);
    }

    final private function __construct(private Site $site)
    {
    }

    public function site(): Site
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

        $links = [];
        foreach ($contents as $content) {
            if (
                $content === '.' or
                $content === '..' or
                $content === '.DS_Store' or
                str_contains($content, '.') or
                str_starts_with($content, '_')
            ) {
                continue;
            }

            $href = $this->site()->requestPath() . '/' . $content;

            $meta = $this->site()->meta($href);
            if (
                is_object($meta) and
                property_exists($meta, 'title')
            ) {
                $links[] = Element::li(
                    Element::a($meta->title)->props('href ' . $href)
                );
            }
        }
        return (string) Element::ul(...$links);
    }
}
