<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\Site;

class HealthLogList implements PartialInterface
{
    public function __invoke(
        PartialInput $input,
        array $extras = []
    ): string {
        // die(var_dump($input->arguments()));
        if (
            array_key_exists('site', $extras) === false or
            array_key_exists('request_path', $extras) === false
        ) {
            return '';
        }

        $arguments = $input->arguments();
        if (property_exists($arguments, 'year') === false) {
            return '';
        }

        $site         = $extras['site'];
        $request_path = $extras['request_path'];
        $year         = $arguments->year;

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
        // $currentYear = [];
        // $years = [];
        foreach ($contents as $content) {
            if (str_starts_with($content, $year) === false) {
                continue;
            }

            $href = $request_path . $content . '/';

            $meta = $site->publicMeta($href);
            $item = '';
            if (
                $meta->notFound() or
                $meta->hasProperty('title') === false
            ) {
                continue;

            }

            $links[$content] = Element::li(
                Element::a($meta->title())->props('href ' . $href)
            );

            // $y = substr($content, 0, 4);
            // $links[$y][$content] = $item;
        }

        // $return = '';

        krsort($links);

        return (string) Element::ul(...$links);
//
//         foreach ($links as $year => $items) {
//             krsort($items);
//
//         }
//
//         return $return;
    }
}
