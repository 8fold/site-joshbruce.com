<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Server\RequestHandlerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Response as PsrResponse;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;
use JoshBruce\SiteDynamic\Documents\FullNav;
use JoshBruce\SiteDynamic\Documents\Sitemap;
use JoshBruce\SiteDynamic\Documents\AtomFeed;

/**
 * Immutable and read-only class for responding to requests.
 *
 * This, admittedly, means it does not fully implement the interface; however,
 * the interfaces aren't divided between read, write, and both.
 *
 * Use with own caution outside this project.
 *
 * @todo Might be worth exploring creating them.
 */
class RequestHandler implements RequestHandlerInterface
{
    private ServerRequestInterface $request;

    private string $requestPath = '';

    private string $contentPublic = '';

    public static function in(Environment $environment): RequestHandler
    {
        return new static($environment);
    }

    final private function __construct(private Environment $environment)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->request = $request;

        $status  = 200;
        $headers = [];

        $isRequestingFile = $this->isRequestingFile();

        $path = $this->contentPublic() . $this->requestPath();
        if (! $isRequestingFile and ! $this->isRequestingXml()) {
            $path = $this->contentPublic() .
                $this->requestPath() .
                $this->environment()->contentFilename();

        }

        $file = File::at($path, $this->contentPublic());

        if ($file->notFound()) {
            $status = 404;
            $path   = $this->contentPublic() . '/error-404.md';

        } else {
            $headers = [
                'Content-type' => $file->mimetype()
            ];

        }

        if ($this->request()->getMethod() === 'HEAD') {
            return new PsrResponse(
                status: $status,
                headers: $headers
            );

        } elseif (
            $isRequestingFile and
            $resource = @\fopen($file->path(), 'r') and
            is_resource($resource)
        ) {
            return new PsrResponse(
                status: $status,
                headers: $headers,
                body: Stream::create($resource)
            );

        }

        $file = PlainTextFile::at($path, $this->contentPublic());

        if ($file->template() === 'sitemap') {
            return new PsrResponse(
                status: $status,
                headers: $headers,
                body: Stream::create(
                    Sitemap::create($file, $this->environment())
                )
            );

        } elseif ($file->template() === 'atom-feed') {
            return new PsrResponse(
                status: $status,
                headers: $headers,
                body: Stream::create(
                    AtomFeed::create($file, $this->environment())
                )
            );
        }

        $pageTitle   = $file->pageTitle();
        $description = $file->description();
        $body        = $this->body($file);

        if ($file->template() === 'full-nav') {
            return new PsrResponse(
                status: $status,
                headers: $headers,
                body: Stream::create(
                    FullNav::create(
                        $pageTitle,
                        $description,
                        Element::main($body),
                        $this->environment()
                    )
                )
            );
        }

        return new PsrResponse(
            status: $status,
            headers: $headers,
            body: Stream::create(
                HtmlDefault::create(
                    $pageTitle,
                    $description,
                    ($this->requestPath() === '/')
                    ? Element::main($body)
                    : Element::article($body)
                        ->props("typeof BlogPosting", "vocab https://schema.org/"),
                    $this->environment()
                )
            )
        );
    }

    private function body(PlainTextFile $file): string
    {
        $markdown = Markdown::processPartials(
            $file->content(),
            $file,
            $this->environment()
        );

        return Markdown::markdownConverter()->convert($markdown);
    }

    private function isRequestingFile(): bool
    {
        return str_contains($this->requestPath(), '.') and
            ! $this->isRequestingXml();
    }

    private function isRequestingXml(): bool
    {
        return str_ends_with($this->requestPath(), '.xml');
    }

    private function requestPath(): string
    {
        if (strlen($this->requestPath) === 0) {
            $this->requestPath = $this->request()->getUri()->getPath();
        }
        return $this->requestPath;
    }

    private function request(): ServerRequestInterface
    {
        return $this->request;
    }

    private function contentPublic(): string
    {
        if (strlen($this->contentPublic) === 0) {
            $this->contentPublic = $this->environment()->contentPublic();
        }
        return $this->contentPublic;
    }

    private function environment(): Environment
    {
        return $this->environment;
    }
}
