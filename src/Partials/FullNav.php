<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Symfony\Component\Finder\Finder;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\SiteInterface;

class FullNav implements PartialInterface
{
    public function __invoke(
        PartialInput $input,
        array $extras = []
    ): string {

        if (array_key_exists('site', $extras) === false) {
            return '';
        }

        $site = $extras['site'];
        if (
            is_object($site) === false or
            $site instanceof SiteInterface === false
        ) {
            return '';
        }

        $publicRoot = $site->publicRoot()->toString();

        $metaFilePaths = (new Finder())->files()->name('meta.json')
            ->in($publicRoot);

        $files = [];
        foreach ($metaFilePaths as $filePath) {
            $filePath  = $filePath->getRealPath();
            $shortPath = str_replace(
                [$publicRoot, 'meta.json'],
                ['', ''],
                $filePath
            );

            if ($shortPath === '') {
                continue;
            }

            $files[$shortPath] = $filePath;
        }

        ksort($files);

        $markdownList = '';
        foreach ($files as $f) {
            $fullPath = $f;

            $path = str_replace(
                [$publicRoot, 'meta.json', '/'],
                ['', '', ''],
                $fullPath
            );

            $json = file_get_contents($fullPath);
            if ($json === false) {
                continue;
            }

            $meta = json_decode($json);
            if (
                is_object($meta) === false or
                property_exists($meta, 'title') === false
            ) {
                continue;
            }

            $title = $meta->title;
            $href  = str_replace(
                [$publicRoot, 'meta.json'],
                ['', ''],
                $fullPath
            );

            if ($href === '/') {
                continue;
            }

            // Building a markdown list using separator count to determine depth.
            $spacesNeeded = (substr_count($href, '/') * 4) - 8;
            $spaces = str_repeat(' ', $spacesNeeded);
            $listItem = "{$spaces}- [{$title}]({$href}) \n";

            $markdownList .= $listItem;
        }

        return $markdownList;
    }
}
