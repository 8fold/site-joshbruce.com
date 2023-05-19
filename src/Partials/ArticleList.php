<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

class ArticleList implements PartialInterface
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

        $path = $site->publicRoot() . $request_path;
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

            $href = $request_path . '/' . $content;

            $meta = $site->publicMeta($href);
            if (
                is_object($meta) and
                $meta->hasProperty('title')
            ) {
                $links[] = Element::li(
                    Element::a($meta->title())->props('href ' . $href)
                );
            }
        }
        return (string) Element::ul(...$links);
    }
}
