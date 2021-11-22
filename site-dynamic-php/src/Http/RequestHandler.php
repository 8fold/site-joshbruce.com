<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Server\RequestHandlerInterface;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Http\Responses\Document as DocumentResponse;
use JoshBruce\SiteDynamic\Http\Responses\File as FileResponse;
use JoshBruce\SiteDynamic\Http\Responses\InternalServerError as InternalServerErrorResponse;
use JoshBruce\SiteDynamic\Http\Responses\NotFound as NotFoundResponse;
use JoshBruce\SiteDynamic\Http\Responses\Redirect as RedirectResponse;
use JoshBruce\SiteDynamic\Http\Responses\UnsupportedMethod as UnsupportedMethodResponse;

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
class RequestHandler implements RequestHandlerInterface, ResponseInterface
{
    private PsrResponse $response;

    public static function in(Finder $finder): RequestHandler
    {
        return new static($finder);
    }

    final private function __construct(
        // private RequestInterface $request,
        private Finder $finder
    ) {
    }

    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        $status = 200;
        if (
            $this->finder::isMissingRequiredFolders() or
            $this->finder::isMisconfiguredEnvironment()
        ) {
            $status = 500;

        } elseif ($this->finder::isUnsupportedMethod($request)) {
            $status = 405;

        } elseif ($this->finder::isMissingFileForRequest($request)) {
            $status = 404;

        // } elseif ($this->finder::fileForRequest($request)->redirect()) {
        //     $status = 301;

        }

        $response = match ($status) {
            500 => InternalServerErrorResponse::respondTo($request),
            405 => UnsupportedMethodResponse::respondTo($request),
            404 => NotFoundResponse::respondTo($request),
            301 => RedirectResponse::respondTo($request),
            default => ($request->isRequestingFile())
                ? FileResponse::respondTo($request)
                : DocumentResponse::respondTo($request)
        };

        die(var_dump($response));
        // $console = [
        //     'file' => __FILE__,
        //     'missing-folders' => , // 500
        //     'misconfigured-env' => , // 500
        //     'missing-file'    => , // 404
        //     'unsupported-method' => , // 405
        //     'file-path-for-request' => $this->finder::filePathForRequest($request),
        //     'is-redirecting' => $this->finder::fileForRequest($request) // 301
        // ];
        // die('<pre>' . print_r(var_dump($console), true) . '</pre>');
        return $this;
    }

    // public static function from(
    //     RequestInterface $request,
    //     Finder $in
    // ): ResponseInterface
    // {
    //     return new Response($request, $in);
    // }

    // final private function __construct(
    //     private RequestInterface $request,
    //     private Finder $finder
    // ) {
    // }

    private function request(): RequestInterface
    {
        return $this->request;
    }

    private function psrResponse(): PsrResponse
    {
        if (! isset($this->response)) {
            $file = $this->finder::fileForRequest($this->request());
            $this->response = new PsrResponse(
                status: $file->statusCode(),
                headers: $file->headers(),
                body: $file->stream(),
                reason: null
            );
        }
        return $this->response;
    }

    /**
     * The following methods aren't used directly,
     * they ensure compliance with the Message contract.
     */
    public function getStatusCode(): int
    {
        return $this->psrResponse()->getStatusCode();
    }

    public function getReasonPhrase(): string
    {
        return $this->psrResponse()->getReasonPhrase();
    }

    public function getHeaders(): array
    {
        return $this->psrResponse()->getHeaders();
    }

    public function getBody(): StreamInterface
    {
        return $this->psrResponse()->getBody();
    }

    public function getProtocolVersion(): string
    {
        return $this->request()->getProtocolVersion();
    }

    public function getHeader($header): array
    {
        return $this->psrResponse()->getHeader($header);
    }

    public function hasHeader($header): bool
    {
        return $this->psrResponse()->hasHeader($header);
    }

    public function getHeaderLine($header): string
    {
        return $this->psrResponse()->getHeaderLine($header);
    }

    /**
     * We want to minimize mutation of state, therefore,
     * these methods only exist to ensure contract compliance.
     */
    public function withStatus($code, $reasonPhrase = ''): self
    {
        return $this;
    }

    public function withProtocolVersion($version): self
    {
        return $this;
    }

    public function withHeader($header, $value): self
    {
        return $this;
    }

    public function withAddedHeader($header, $value): self
    {
        return $this;
    }

    public function withoutHeader($header): self
    {
        return $this;
    }

    public function withBody(StreamInterface $body): self
    {
        return $this;
    }
}
