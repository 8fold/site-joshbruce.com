<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Server\RequestHandlerInterface;

// use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Message\StreamInterface;

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
use JoshBruce\SiteDynamic\Http\Responses\Redirect as RedirectResponse;
use JoshBruce\SiteDynamic\Http\Responses\UnsupportedMethod as
    UnsupportedMethodResponse;

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

    public static function in(
        Finder $finder,
        Environment $environment
    ): RequestHandler {
        return new static($finder, $environment);
    }

    final private function __construct(
        private Finder $finder,
        private Environment $environment
    ) {
    }

    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        $this->request = $request;

        if (
            $this->environment()->isMissingVariables() or
            $this->environment()->isMissingFolders()
        ) {
            return InternalServerErrorResponse::with(
                $this->fileForPath(
                    $this->environment()->publicRoot() . '/error-500.html'
                ),
                $this->environment(),
                $this->request()
            )->respond();

        } elseif ($this->isUnsupportedMethod()) {
            return UnsupportedMethodResponse::with(
                $this->fileForPath(
                    $this->environment()->publicRoot() . '/error-405.md'
                ),
                $this->environment(),
                $this->request()
            )->respond();

        }

        $path = $this->fileUri();

        if (
            $this->isRedirecting($path) and
            $p = $this->redirectFilePath($path)
        ) {
            return RedirectResponse::with(
                $this->fileForPath($p),
                $this->environment(),
                $this->request()
            )->respond();

        }

        if (! file_exists($path) or ! is_file($path)) {
            return NotFoundResponse::with(
                $this->fileForPath(
                    $this->environment()->publicRoot() . '/error-404.md'
                ),
                $this->environment(),
                $this->request()
            )->respond();

        }

        if ($this->isRequestingContent()) {
            return DocumentResponse::with(
                $this->fileForPath($path),
                $this->environment(),
                $this->request()
            )->respond();

        }

        return FileResponse::with(
            $this->fileForPath($path),
            $this->environment(),
            $this->request()
        )->respond();
    }

    private function fileForPath(string $path): File|PlainTextFile
    {
        if ($this->pathIsFile($path)) {
            return PlainTextFile::at(
                $path,
                $this->environment()->publicRoot()
            );

        }

        return File::at(
            $path,
            $this->environment()->publicRoot()
        );
    }

    private function isRedirecting(string $path): bool
    {
        if (file_exists($path) and is_file($path)) {
            return false;
        }

        $path = $this->redirectFilePath($path);

        return file_exists($path) and is_file($path);
    }

    private function redirectFilePath(string $path): string
    {
        // Either a 404 or redirect
        $parts = explode('/', $path);

        $fileName = '~' . array_pop($parts);
        $parent   = '~' . array_pop($parts);

        $parts[] = $parent;
        $parts[] = $fileName;

        return implode('/', $parts);
    }

    private function isUnsupportedMethod(): bool
    {
        return ! in_array(
            strtoupper($this->request()->getMethod()),
            $this->environment()->supportedMethods()
        );
    }

    private function isRequestingContent(): bool
    {
        return ! $this->isRequestingFile();
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
        return $this->request()->getUri()->getPath();
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

    private function finder(): Finder
    {
        return $this->finder;
    }

    private function request(): ServerRequestInterface
    {
        return $this->request;
    }
}
