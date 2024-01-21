<?php
declare(strict_types=1);

namespace JoshBruce\Site\Templates;

use Stringable;

use Eightfold\Markdown\Markdown;

use Eightfold\Amos\Site;
use Eightfold\Amos\FileSystem\Path;
use Eightfold\Amos\PlainText\PrivateFile;
use Eightfold\Amos\ObjectsFromJson\PrivateObject;

use JoshBruce\Site\Documents\Main;

class PageNotFound implements Stringable
{
    private Markdown $converter;

    private Path $requestPath;

    public static function create(Site $site): self
    {
        return new self($site);
    }

    final private function __construct(private readonly Site $site)
    {
    }

    private function site(): Site
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

    private function converter(): Markdown
    {
        return $this->converter;
    }

    public function __toString(): string
    {
        $meta = PrivateObject::inRoot(
            $this->site()->contentRoot(),
            'meta.json',
            '/errors/404'
        );

        $content = PrivateFile::inRoot(
            $this->site()->contentRoot(),
            'content.md',
            '/errors/404'
        );

        if ($meta->notFound() or $content->notFound()) {
            return '404: Page not found.';
        }

        return (string) Main::create($this->site(), $this->requestPath())
            ->setPageTitle($meta->title())
            ->setBody(
                $this->converter()->convert($content->toString())
            );
    }
}
