<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;
use JoshBruce\SiteDynamic\Documents\FullNav;
use JoshBruce\SiteDynamic\Documents\Sitemap;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class Document
{
    use ResponseCycleTrait;

    public function statusCode(): int
    {
        return 200;
    }

    public function headers(): array
    {
        return [
            'Content-Type' => [
                $this->file->mimetype()->interpreted()
            ]
        ];
    }

    public function stream(): StreamInterface
    {
        if ($this->request->getMethod() === 'HEAD') {
            return Stream::create('');
        }

        $content = Markdown::processPartials(
            $this->file->content(),
            $this->file
        );

        return match ($this->file->template()) {
            'full-nav' => $this->fullNav($content),
            'sitemap'  => $this->sitemap($content),
            default    => $this->default($content)
        };
    }

    private function default(string $content): Stream
    {
        return Stream::create(
            HtmlDefault::create(
                $this->file->pageTitle(),
                '',
                Element::main(
                    Markdown::markdownConverter()->convert($content)
                ),
                $this->environment
            )
        );
    }

    private function fullNav(string $content): Stream
    {
        return Stream::create(
            FullNav::create(
                $this->file->pageTitle(),
                '',
                Element::main(
                    Markdown::markdownConverter()->convert($content)
                ),
                $this->environment
            )
        );
    }

    private function sitemap(string $content): Stream
    {
        return Stream::create(
            Sitemap::create($this->file)
        );
    }
}
