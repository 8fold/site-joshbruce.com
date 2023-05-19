<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\Site;

class PaycheckLogList implements PartialInterface
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

        $site         = $extras['site'];
        $request_path = $extras['request_path'];

        if (
            (is_object($site) === false or
            is_a($site, Site::class) === false) or
            is_string($request_path) === false
        ) {
            return '';
        }

        $path = $site->publicRoot() . $request_path;

        $contents = scandir($path);
        if ($contents === false) {
            return '';
        }

        $links = [];
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

            $href = $request_path . '/' . $content;

            $meta = $site->publicMeta($href);
            $item = '';
            if (
                $meta->notFound() or
                $meta->hasProperty('title') === false
            ) {
                continue;

            } else {
                $item = Element::li(
                    Element::a($meta->title())->props('href ' . $href)
                );

            }

            $year = date('Y');
            if (str_starts_with($content, $year)) {
                $currentYear[$content] = $item;
                continue;
            }

            $year = substr($content, 0, 4);
            $links[$year][$content] = $item;
        }

        $return = '';
        if (count($currentYear) > 0) {
            krsort($currentYear);
            $return = (string) Element::ul(...$currentYear);
        }

        krsort($links);

        $pastYears = [];
        foreach ($links as $year => $items) {
            krsort($items);
            $return .= (string) Element::details(
                Element::summary(strval($year)),
                Element::ul(...$items)
            );
        }

        return $return;
    }
}
