<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Symfony\Component\Finder\Finder;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;
use Eightfold\Amos\Markdown;

class FullNav implements Buildable
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
        $finder = (new Finder())->files()->name('meta.json')->in(
            $this->site()->publicRoot()
        );

        $publicRoot = $this->site()->publicRoot();
        $contentFilename = 'content.md';

        $files = [];
        foreach ($finder as $fileInfo) {
            $filePath  = $fileInfo->getRealPath();
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
            $meta = json_decode($json);
            if (
                $meta === false or
                $meta === null or
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

        return Markdown::convert($this->site(), $markdownList);
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
