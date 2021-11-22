<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\Content\Markdown;

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
class Response implements ResponseInterface
{
    private PsrResponse $response;

    private File $file;

    private const ENV_REQUIRED = [
        'APP_ENV',
        'APP_URL'
    ];

    private const SUPPORTED_METHODS = [
      'GET'
    ];

    public static function from(
        RequestInterface $request,
        Finder $in
    ): ResponseInterface
    {
        return new Response($request, $in);
    }

    final private function __construct(
        private RequestInterface $request,
        private Finder $finder
    ) {
    }

    private function request(): RequestInterface
    {
        return $this->request;
    }

    private function finder(): Finder
    {
        return $this->finder;
    }

    private function psrResponse(): PsrResponse
    {
        if (! isset($this->response)) {
            $this->response = new PsrResponse(
                status: $this->statusCode(),
                headers: $this->file()->headers(),
                body: $this->file()->stream(),
                reason: null
            );
        }
        return $this->response;
    }

    private function statusCode(): int
    {
        if (
            $this->envIsMissingRequiredKey() or
            $this->finder()->isMissingRequiredFolders()
        ) {
            return 500;

        } elseif ($this->isUnsupportedMethod()) {
            return 405;

        } elseif ($this->file()->isNotFound()) {
            return 404;

        } elseif ($redirect = $this->file()->redirect()) {
            // TODO: create HttpRedirect??
            // @phpstan-ignore-next-line
            $code = $redirect->code;
            return ($code >= 300 and $code <= 399) ? $code : 500;

        }
        return 200;
    }

    private function file(): File
    {
        if (! isset($this->file)) {
            $this->file = $this->finder()->publicFileForRequest(
                $this->request(),
                $this->finder()->publicRoot(),
                $this->statusCode()
            );
        }
        return $this->file;
    }

    private function envIsMissingRequiredKey(): bool
    {
        return ! $this->envHasRequiredKeys();
    }

    private function envHasRequiredKeys():bool
    {
        foreach (self::ENV_REQUIRED as $key) {
            if (! array_key_exists($key, $_SERVER)) {
                return false;
            }
        }
        return true;
    }

    private function isUnsupportedMethod(): bool
    {
        return ! $this->isSupportedMethod();
    }

    private function isSupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->request()->getMethod());
        return in_array($requestMethod, self::SUPPORTED_METHODS);
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
