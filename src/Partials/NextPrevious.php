<?php

declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class NextPrevious implements Buildable
{
    private Meta $meta;

    private Content $content;

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

    public function build(): string
    {
        $path = $this->site()
            ->contentPath(at: $this->site()->requestPath());

        $pathParts = explode('/', $path);

        array_pop($pathParts);

        $folderName  = array_pop($pathParts);
        $folderAsInt = intval($folderName);

        $parentPath = implode('/', $pathParts);

        if (is_dir($parentPath) === false) {
            return '';
        }

        $contents     = scandir($parentPath);
        $foundCurrent = false;
        $previousPath     = '';
        $nextPath         = '';
        foreach ($contents as $content) {
            if (
                $content === '.' or
                $content === '..' or
                $content === '.DS_Store' or
                str_contains($content, '.')
            ) {
                continue;
            }

            if ($content === $folderName) {
                $foundCurrent = true;
                continue;
            }

            $contentAsInt = intval($content);

            if ($foundCurrent === false and $contentAsInt < $folderAsInt) {
                $previousPath = $parentPath . '/' . $content;
                continue;
            }

            if ($foundCurrent === true and $contentAsInt > $folderAsInt) {
                $nextPath = $parentPath . '/' . $content;
                break;
            }
        }

        $previous = '';
        if (strlen($previousPath) > 0) {
            list($root, $request) = explode('public', $previousPath, 2);
            $meta = $this->site()->meta(at: $request);
            if ($meta !== false and property_exists($meta, 'title')) {
                $previous = Element::li(
                    Element::a($meta->title)->props('href ' . $request . '/')
                );
            }
        }

        $next = '';
        if (strlen($nextPath) > 0) {
            list($root, $request) = explode('public', $nextPath, 2);
            $meta = $this->site()->meta(at: $request);
            if ($meta !== false and property_exists($meta, 'title')) {
                $next = Element::li(
                    Element::a($meta->title)->props('href ' . $request . '/')
                );
            }
        }

        return Element::ul($previous, $next)->props('is next-previous')->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
