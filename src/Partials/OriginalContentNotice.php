<?php

declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\XMLBuilder\Contracts\Buildable;

use StdClass;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;
use Eightfold\Amos\Markdown;

class OriginalContentNotice
{
    private const COMPONENT_WRAPPER = '{!! platformlink !!}';

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

    private function originalNotice(): string
    {
        $path = $this->site()->contentRoot() . '/notices/original.md';
        if (file_exists($path) == false) {
            return '';
        }

        return file_get_contents($path);
    }

    public function build(): string
    {
        $noticeMarkdown = $this->originalNotice();
        if (strlen($noticeMarkdown) === 0) {
            return '';
        }

        $meta = $this->site()->meta(at: $this->site()->requestPath());
        if ($meta === false) {
            return '';
        }

        $original = $meta->original;
        list($href, $platform) = explode(' ', $original, 2);

        $matches = [];
        $search  = '/' . self::COMPONENT_WRAPPER . '/';
        if (! preg_match($search, $noticeMarkdown, $matches)) {
            return '';
        }

        $noticeMarkdown = preg_replace(
            $search,
            "[{$platform}]({$href})",
            $noticeMarkdown
        );
        if ($noticeMarkdown === null) {
            return '';
        }

        return Markdown::convert($this->site(), $noticeMarkdown);
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
