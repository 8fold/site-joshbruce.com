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
use JoshBruce\SiteDynamic\FileSystem\PlainTextFileFromAlias;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;
use JoshBruce\SiteDynamic\Documents\FullNav;
use JoshBruce\SiteDynamic\Documents\Sitemap;

use JoshBruce\SiteDynamic\FileSystem\Aliases;

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

    private int $status = 200;

    /**
     * @var array<string, string>
     */
    private array $headers = [];

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

        $this->status   = 200;
        $this->headers = [];

        $path = $this->contentPublic() . $this->requestPath();
        $file = File::at($path, $this->contentPublic());
        if (str_ends_with($path, '/')) {
            $path = $this->contentPublic() . $this->requestPath() .
                $this->environment()->contentFilename();
            $file = PlainTextFile::at($path, $this->contentPublic());
        }

        if ($file->notFound()) {
            $this->status = 404;

            if ($this->request()->getMethod() !== 'HEAD') {
                $path = $this->contentPublic() . '/error-404.md';
                $file = PlainTextFile::at($path, $this->contentPublic());
                $body = $this->body($file);

                return new PsrResponse(
                    status: $this->status(),
                    headers: $this->headers(),
                    body: Stream::create(
                        HtmlDefault::create(
                            $file->pageTitle(),
                            $file->description(),
                            ($this->requestPath() === '/')
                            ? Element::main($body)
                            : Element::article($body),
                            $this->environment()
                        )
                    )
                );

            }
        } elseif ($this->isRequestingXml() or $this->isRequestingFile()) {
            $this->headers = [
                'Content-type' => $file->mimetype()
            ];

            if ($this->request()->getMethod() === 'HEAD') {
                // head-only response
                return new PsrResponse(
                    status: $this->status(),
                    headers: $this->headers()
                );

            }
        }

        if ($this->request()->getMethod() === 'HEAD') {
            // head-only response
            return new PsrResponse(
                status: $this->status(),
                headers: $this->headers()
            );
        }

        // non-text files
        if (
            $this->isRequestingFile() and
            $resource = @\fopen($file->path(), 'r') and
            is_resource($resource)
        ) {
            return new PsrResponse(
                status: $this->status(),
                headers: $this->headers(),
                body: Stream::create($resource)
            );
        }

        // text files
        $file = PlainTextFile::at($path, $this->contentPublic());
        if ($this->isRequestingXml() and $file->template() === 'sitemap') {
            return new PsrResponse(
                status: $this->status(),
                headers: $this->headers(),
                body: Stream::create(
                    Sitemap::create($file, $this->environment())
                )
            );

        }

        if ($file->alias()) {
            $path = $this->environment()->contentPrivate() . '/' .
                $file->alias() . '/' .
                $this->environment()->contentFilename();
            $file = PlainTextFileFromAlias::at(
                $path,
                $this->environment()->contentPrivate(),
                $file
            );

        }

        $pageTitle   = $file->pageTitle();
        $description = $file->description();
        $body        = $this->body($file);

        // text content response
        return new PsrResponse(
            status: $this->status(),
            headers: $this->headers(),
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

    private function status(): int
    {
        return $this->status;
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return $this->headers;
    }

    private function body(PlainTextFile|PlainTextFileFromAlias $file): string
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
