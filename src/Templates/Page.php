<?php
declare(strict_types=1);

namespace JoshBruce\Site\Templates;

use Stringable;

use Eightfold\HTMLBuilder\Components\PageTitle;

use Eightfold\Markdown\Markdown;

use Eightfold\Amos\SiteInterface;
use Eightfold\Amos\FileSystem\Path;
use Eightfold\Amos\ObjectsFromJson\PublicMeta;
use Eightfold\Amos\PlainText\PublicContent;

use JoshBruce\Site\Documents\Main;

use JoshBruce\Site\Partials\DateBlock;
use JoshBruce\Site\Partials\NextPrevious;
use JoshBruce\Site\Partials\ArticleList;
use JoshBruce\Site\Partials\PaycheckLogList;
use JoshBruce\Site\Partials\OriginalContentNotice;
use JoshBruce\Site\Partials\Data;
use JoshBruce\Site\Partials\FiExperiments;
use JoshBruce\Site\Partials\FullNav;
use JoshBruce\Site\Partials\HealthLogList;

class Page implements Stringable
{
    private Markdown $converter;

    private Path $requestPath;

    public static function create(SiteInterface $site): self
    {
        return new self($site);
    }

    final private function __construct(private SiteInterface $site)
    {
    }

    public function site(): SiteInterface
    {
        return $this->site;
    }

    public function withRequestPath(Path $requestPath): self
    {
        $this->requestPath = $requestPath;
        return $this;
    }

    public function requestPath(): Path
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

        $converter = $this->converter();
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
