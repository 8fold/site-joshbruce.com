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
            $response = InternalServerErrorResponse::with(
                PlainTextFile::at(
                    $this->environment()->publicRoot() . '/error-500.html',
                    $this->environment()->publicRoot()
                ),
                $this->environment(),
                $this->request()
            );

            return new PsrResponse(
                status: $response->statusCode(),
                headers: $response->headers(),
                body: $response->stream()
            );

        } elseif ($this->isUnsupportedMethod()) {
            $response = UnsupportedMethodResponse::with(
                PlainTextFile::at(
                    $this->environment()->publicRoot() . '/error-405.md',
                    $this->environment()->publicRoot()
                ),
                $this->environment(),
                $this->request()
            );

            return new PsrResponse(
                status: $response->statusCode(),
                headers: $response->headers(),
                body: $response->stream()
            );

        }

        $path = $this->fileUri();

        if (
            $this->isRedirecting($path) and
            $p = $this->redirectFilePath($path)
        ) {
            $file = File::at($p, $this->environment()->publicRoot());

            if ($this->isRequestingContent()) {
                $file = PlainTextFile::at(
                    $p,
                    $this->environment()->publicRoot()
                );
            }

            $response = RedirectResponse::with(
                $file,
                $this->environment(),
                $this->request()
            );

            return new PsrResponse(
                status: $response->statusCode(),
                headers: $response->headers(),
                body: $response->stream()
            );
        }

        if (! file_exists($path) or ! is_file($path)) {
            $response = NotFoundResponse::with(
                PlainTextFile::at(
                    $this->environment()->publicRoot() . '/error-404.md',
                    $this->environment()->publicRoot()
                ),
                $this->environment(),
                $this->request()
            );

            return new PsrResponse(
                status: $response->statusCode(),
                headers: $response->headers(),
                body: $response->stream()
            );
        }

        $file = File::at($path, $this->environment()->publicRoot());
        if ($this->isRequestingContent()) {
            $file = PlainTextFile::at(
                $path,
                $this->environment()->publicRoot()
            );
        }

        $response = ($this->isRequestingFile())
            ? FileResponse::respondTo(
                $file,
                $this->environment(),
                $this->request()
            )
            : DocumentResponse::respondTo(
                $file,
                $this->environment(),
                $this->request()
            );

        return new PsrResponse(
            status: $response->statusCode(),
            headers: $response->headers(),
            body: $response->stream()
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
        $parts            = explode('/', $this->requestPath());
        $possibleFileName = array_pop($parts);

        return str_contains($possibleFileName, '.');
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
