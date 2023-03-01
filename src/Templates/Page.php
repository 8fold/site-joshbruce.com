<?php
declare(strict_types=1);

namespace JoshBruce\Site\Templates;

use Stringable;
// use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\Amos\Site;

use Eightfold\Amos\Markdown;
use Eightfold\Amos\PageComponents\PageTitle;

use JoshBruce\Site\Documents\Main;

use JoshBruce\Site\Partials\DateBlock;
use JoshBruce\Site\Partials\NextPrevious;
use JoshBruce\Site\Partials\ArticleList;
use JoshBruce\Site\Partials\LogList;
use JoshBruce\Site\Partials\PaycheckLogList;
use JoshBruce\Site\Partials\OriginalContentNotice;
use JoshBruce\Site\Partials\Data;
use JoshBruce\Site\Partials\FiExperiments;
use JoshBruce\Site\Partials\FullNav;

class Page implements Stringable // Buildable
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

    public function __toString(): string
    {
        $path = $this->site()->requestPath();
        $markdown = $this->site()->content(at: $path);
        if ($markdown === '') {
            return '';
        }

        $meta = $this->site()->meta(at: $path);

        $main = Main::create($this->site())
            ->setPageTitle(
                (string) PageTitle::create($this->site())
            )->setBody(
                Markdown::convert(
                    $this->site(),
                    $markdown,
                    [
                        'dateblock'        => DateBlock::class,
                        'next-previous'    => NextPrevious::class,
                        'article-list'     => ArticleList::class,
                        'loglist'          => LogList::class,
                        'paycheck-loglist' => PaycheckLogList::class,
                        'original'         => OriginalContentNotice::class,
                        'data'             => Data::class,
                        'fi-experiments'   => FiExperiments::class,
                        'full-nav'         => FullNav::class
                    ]
                )
            );

        if (is_object($meta) and property_exists($meta, 'schemaType')) {
            $main = $main->setSchemaType($meta->schemaType);
        }

        return (string) $main;
    }
}
