<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

class LogList implements PartialInterface
{
    public function __invoke(
        PartialInput $input,
        array $extras = []
    ): string {
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

        return (string) Element::ul(...$links);
    }
}
