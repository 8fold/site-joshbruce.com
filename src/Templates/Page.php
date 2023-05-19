<?php
declare(strict_types=1);

namespace JoshBruce\Site\Templates;

use Stringable;

use Eightfold\HTMLBuilder\Components\PageTitle;

use Eightfold\Markdown\Markdown;

use Eightfold\Amos\Site;
use Eightfold\Amos\ObjectsFromJson\PublicMeta;
use Eightfold\Amos\PlainText\PublicContent;

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

class Page implements Stringable
{
    private Markdown $converter;

    private string $requestPath;

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

    public function withRequestPath(string $requestPath): self
    {
        $this->requestPath = $requestPath;
        return $this;
    }

    public function requestPath(): string
    {
        return $this->requestPath;
    }

    public function withConverter(Markdown $converter): self
    {
        $this->converter = $converter;
        return $this;
    }

    public function converter(): Markdown
    {
        return $this->converter;
    }

    public function __toString(): string
    {
        $meta = PublicMeta::inRoot(
            $this->site()->contentRoot(),
            $this->requestPath()
        );

        $content = PublicContent::inRoot(
            $this->site()->contentRoot(),
            $this->requestPath()
        );

        if ($meta->notFound() or $content->notFound()) {
            return (string) PageNotFound::create($this->site())
                ->withConverter($this->converter())
                ->withRequestPath($this->requestPath());
        }

        $converter = $this->converter()->partials([
            'partials' => [
                'dateblock'        => DateBlock::class,
                'next-previous'    => NextPrevious::class,
                'article-list'     => ArticleList::class,
                'loglist'          => LogList::class,
                'paycheck-loglist' => PaycheckLogList::class,
                'original'         => OriginalContentNotice::class,
                'data'             => Data::class,
                'fi-experiments'   => FiExperiments::class,
                'full-nav'         => FullNav::class
            ],
            'extras' => [
                'meta'         => $meta,
                'site'         => $this->site(),
                'request_path' => $this->requestPath()
            ]
        ]);

        $main = Main::create($this->site(), $this->requestPath())
            ->setPageTitle(
                (string) PageTitle::create($this->site()->titles(
                    $this->requestPath()
                ))
            )->setBody($converter->convert(
                $content->toString()
            ));

        if ($meta->hasProperty('schemaType')) {
            $main = $main->setSchemaType($meta->schemaType());
        }

        return (string) $main;
    }
}
