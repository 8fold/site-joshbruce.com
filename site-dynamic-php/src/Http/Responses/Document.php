<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;

use Nyholm\Psr7\Response as PsrResponse;
use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;
use JoshBruce\SiteDynamic\Documents\FullNav;
use JoshBruce\SiteDynamic\Documents\Sitemap;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class Document
{
    public static function with(
        PlainTextFile $file,
        Environment $environment,
        ServerRequestInterface $request
    ): static {
        return new static($file, $environment, $request);
    }

    final private function __construct(
        private PlainTextFile $file,
        private Environment $environment,
        private ServerRequestInterface $request
    ) {
    }

    public function respond(): ResponseInterface
    {
        return new PsrResponse(
            status: $this->statusCode(),
            headers: $this->headers(),
            body: $this->stream($this->file, $this->environment)
        );
    }

    public function statusCode(): int
    {
        return 200;
    }

    /**
     * @return array<string, string|string[]>
     */
    public function headers(): array
    {
        return [
            'Content-Type' => [
                $this->file->mimetype()->interpreted()
            ]
        ];
    }

    public function stream(
        PlainTextFile $file,
        Environment $environment
    ): StreamInterface {
        $content = Markdown::processPartials(
            $file->content(),
            $file,
            $environment->contentFilename()
        );

        return match ($file->template()) {
            'full-nav' => $this->fullNav($content),
            'sitemap'  => $this->sitemap($content),
            default    => $this->default($content)
        };
    }

    private function default(string $content): StreamInterface
    {
        return Stream::create(
            HtmlDefault::create(
                $this->file->pageTitle(),
                $this->file->description(),
                Element::main(
                    Markdown::markdownConverter()->convert($content)
                ),
                $this->environment
            )
        );
    }

    private function fullNav(string $content): StreamInterface
    {
        return Stream::create(
            FullNav::create(
                $this->file->pageTitle(),
                $this->file->description(),
                Element::main(
                    Markdown::markdownConverter()->convert($content)
                ),
                $this->environment
            )
        );
    }

    private function sitemap(string $content): StreamInterface
    {
        return Stream::create(
            Sitemap::create($this->file, $this->environment)
        );
    }
}
