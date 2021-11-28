<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Server\RequestHandlerInterface;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Response as PsrResponse;

use Eightfold\HTMLBuilder\Element;

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

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

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

    private string $publicRoot = '';

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
// if folders are missing, there is no way to get the content
//         if ($this->environment()->isMissingFolders()) {
//             $status = 500;
//             if ($this->request()->getMethod() === 'HEAD') {
//                 return new PsrResponse(
//                     status: $status,
//                     headers: $headers
//                 );
//             }
//
//             return new PsrResponse(
//                 status: 500,
//                 headers: [],
//                 body: Stream::create(
//                     PlainTextFile::at(
//                         $this->publicRoot() . '/error-500.html',
//                         $this->publicRoot()
//                     )->content()
//                 )
//             );
//         }

        $isRequestingFile = $this->isRequestingFile();
        $path = $this->publicRoot() . $this->requestPath();
        if (! $isRequestingFile and ! $this->isRequestingXml()) {
            $path = $this->publicRoot() .
                $this->requestPath() .
                $this->environment()->contentFilename();

        }

        $file = File::at($path, $this->publicRoot());

        if ($file->notFound()) {
            $status = 404;
            $path   = $this->publicRoot() . '/error-404.md';

        } else {
            $headers = [
                'Content-type' => $file->mimetype()->interpreted()
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

        return DocumentResponse::with(
            PlainTextFile::at($path, $this->publicRoot()),
            $this->environment(),
            $this->request()
        )->respond();
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

    private function publicRoot(): string
    {
        if (strlen($this->publicRoot) === 0) {
            $this->publicRoot = $this->environment()->publicRoot();
        }
        return $this->publicRoot;
    }

    private function environment(): Environment
    {
        return $this->environment;
    }
}
