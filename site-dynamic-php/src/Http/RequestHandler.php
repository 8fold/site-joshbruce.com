<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Server\RequestHandlerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Http\Responses\Document as DocumentResponse;
use JoshBruce\SiteDynamic\Http\Responses\File as FileResponse;
use JoshBruce\SiteDynamic\Http\Responses\InternalServerError as
    InternalServerErrorResponse;
use JoshBruce\SiteDynamic\Http\Responses\NotFound as NotFoundResponse;

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

        if (
            $this->environment()->isMissingVariables() or
            $this->environment()->isMissingFolders()
        ) {
            return InternalServerErrorResponse::with(
                PlainTextFile::at(
                    $this->environment()->publicRoot() . '/error-500.html',
                    $this->environment()->publicRoot()
                ),
                $this->environment(),
                $this->request()
            )->respond();

        }

        $path = $this->fileUri();

        if (! file_exists($path) or ! is_file($path)) {
            return NotFoundResponse::with(
                PlainTextFile::at(
                    $this->environment()->publicRoot() . '/error-404.md',
                    $this->environment()->publicRoot()
                ),
                $this->environment(),
                $this->request()
            )->respond();
        }

        if (
            $this->isRequestingContent() or
            $this->isRequestingXml()
        ) {
            return DocumentResponse::with(
                PlainTextFile::at($path, $this->environment()->publicRoot()),
                $this->environment(),
                $this->request()
            )->respond();
        }

        return FileResponse::with(
            File::at(
                $path,
                $this->environment()->publicRoot()
            ),
            $this->request()
        )->respond();
    }

    private function isRequestingContent(): bool
    {
        return ! $this->isRequestingFile();
    }

    private function isRequestingXml(): bool
    {
        return str_ends_with($this->requestPath(), '.xml');
    }

    private function isRequestingFile(): bool
    {
        return $this->pathIsFile($this->requestPath());
    }

    private function pathIsFile(string $path): bool
    {
        $parts            = explode('/', $path);
        $possibleFileName = array_pop($parts);

        if (! str_contains($possibleFileName, '.')) {
            return false;
        }

        // could be file
        if (! str_starts_with($path, $this->environment()->publicRoot())) {
            // need to add full path
            $path = $this->environment()->publicRoot() . $path;
        }

        $f = File::at($path, $this->environment()->publicRoot());

        if ($f->mimetype()->name() === 'text') {
            return false;
        }
        return true;
    }

    private function requestPath(): string
    {
        if (strlen($this->requestPath) === 0) {
            $this->requestPath = $this->request()->getUri()->getPath();
        }
        return $this->requestPath;
    }

    private function fileUri(): string
    {
        $uri = $this->environment()->publicRoot() . $this->requestPath();

        return ($this->isRequestingFile())
            ? $uri
            : $uri . '/' . $_SERVER['CONTENT_FILENAME'];
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function request(): ServerRequestInterface
    {
        return $this->request;
    }
}
