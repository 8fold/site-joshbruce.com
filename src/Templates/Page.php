<?php
declare(strict_types=1);

namespace JoshBruce\Site\Templates;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Amos\Site;

use Eightfold\Amos\Markdown;
use Eightfold\Amos\PageComponents\PageTitle;

use JoshBruce\Site\Documents\Main;

use JoshBruce\Site\Partials\DateBlock;
use JoshBruce\Site\Partials\NextPrevious;

class Page implements Buildable
{
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
        $path = $this->site()->requestPath();
        $markdown = $this->site()->content(at: $path);
        if ($markdown === '') {
            return '';
        }

        return Main::create($this->site())
            ->setPageTitle(
                PageTitle::create($this->site())->build()
            )->setBody(
                Markdown::convert(
                    $this->site(),
                    $markdown,
                    [
                        'dateblock' => DateBlock::class,
                        'next-previous' => NextPrevious::class
                    ]
                )
            )->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
