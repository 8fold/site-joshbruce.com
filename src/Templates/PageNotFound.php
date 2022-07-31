<?php
declare(strict_types=1);

namespace JoshBruce\Site\Templates;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Amos\Site;
use Eightfold\Amos\Markdown;

use JoshBruce\Site\Documents\Main;

class PageNotFound implements Buildable
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
        $errorPath = $this->site()->contentRoot() . '/errors/404';

        $content = $errorPath . '/content.md';
        $markdown = '404: Page not found.';
        if (file_exists($content)) {
            $markdown = file_get_contents($content);
        }

        $meta = $errorPath . '/meta.json';
        $pageTitle = 'Page not found';
        if (
            file_exists($meta) and
            $json = file_get_contents($meta) and
            $decoded = json_decode($json) and
            property_exists($decoded, 'title')
        ) {
            $pageTitle = $decoded->title;
        }

        return Main::create($this->site())
            ->setPageTitle($pageTitle)
            ->setBody(
                Markdown::convert(
                    $this->site(),
                    $markdown
                )
            )->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
