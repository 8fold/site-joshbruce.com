<?php
declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Stringable;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\SiteInterface;
use Eightfold\Amos\FileSystem\Path;

class Breadcrumbs implements Stringable // Buildable
{
    public static function create(SiteInterface $site, Path $requestPath): self
    {
        return new self($site, $requestPath);
    }

    final private function __construct(
        private readonly SiteInterface $site,
        private readonly Path $requestPath
    ) {
    }

    public function site(): SiteInterface
    {
        return $this->site;
    }

    public function __toString(): string
    {
        $linkStack = $this->site()->linkStack($this->requestPath);

        $hideBreadcrumbsAtDepth            = 2;
        $startDisplayingBreadcrumbsAtDepth = $hideBreadcrumbsAtDepth + 1;


        $depth = count($linkStack);

        if ($depth <= $startDisplayingBreadcrumbsAtDepth) {
            return '';
        }

        $length = $depth - $startDisplayingBreadcrumbsAtDepth;

        $links = $this->site()->breadcrumbs($this->requestPath, $hideBreadcrumbsAtDepth, $length);

        $l = [];
        $requestPath = $this->requestPath;
        foreach ($links as $href => $title) {
            $a = Element::a($title)->props('href ' . $href);

            $l[] = Element::li($a);
        }

        return (string) Element::nav(
            Element::ul(...$l)->props('class col-' . count($links))
        )->props('is breadcrumb-nav', 'aria-label secondary navigation');
    }
}
