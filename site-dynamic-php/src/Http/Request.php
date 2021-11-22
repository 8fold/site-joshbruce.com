<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7Server\ServerRequestCreator as PsrServerRequestCreator;

use JoshBruce\SiteDynamic\Http\Uri;
use JoshBruce\SiteDynamic\FileSystem\Finder;

/**
 * Immutable and read-only class for capturing request details.
 *
 * This, admittedly, means it does not fully implement the interface; however,
 * the interfaces aren't divided between read, write, and both.
 *
 * Use with own caution outside this project.
 *
 * @todo Might be worth exploring creating them.
 */
class Request implements RequestInterface
{
    private PsrServerRequestCreator $creator;

    private RequestInterface $psrRequest;

    public static function fromGlobals(): Request
    {
        return new static();
    }

    final private function __construct()
    {
    }

    public function isRequestingContent(): bool
    {
        return ! $this->isRequestingFile();
    }

    public function isRequestingFile(): bool
    {
        return $this->getUri()->isFile();
    }

    private function psrRequest(): RequestInterface
    {
        if (! isset($this->psrRequest)) {
            $this->psrRequest = $this->creator()->fromGlobals();
        }
        return $this->psrRequest;
    }

    private function creator(): PsrServerRequestCreator
    {
        if (! isset($this->creator)) {
            $psr17Factory  = new PsrFactory();
            $uriFactory    = new Uri();
            $this->creator = new PsrServerRequestCreator(
                serverRequestFactory: $psr17Factory,
                uriFactory: $uriFactory,
                uploadedFileFactory: $psr17Factory,
                streamFactory: $psr17Factory
            );
        }
        return $this->creator;
    }

    /**
     * RequestInterface methods
     */
    public function getUri(): UriInterface
    {
        return $this->psrRequest()->getUri();
    }

    public function getMethod(): string
    {
        return $this->psrRequest()->getMethod();
    }

    /**
     * The following methods aren't used directly,
     * they ensure compliance with the Request contract.
     */
    public function getRequestTarget(): string
    {
        return $this->psrRequest()->getRequestTarget();
    }

    /**
     * The following methods aren't used directly,
     * they ensure compliance with the Message contract.
     */
    public function getProtocolVersion(): string
    {
        return $this->psrRequest()->getProtocolVersion();
    }

    public function getHeaders(): array
    {
        return $this->psrRequest()->getHeaders();
    }

    public function hasHeader($header): bool
    {
        return $this->psrRequest()->hasHeader($header);
        return $this;
    }

    public function getHeader($header): array
    {
        return $this->psrRequest()->getHeader($header);
    }

    public function getHeaderLine($header): string
    {
        return $this->psrRequest()->getHeaderLine($header);
    }

    public function getBody(): StreamInterface
    {
        return $this->psrRequest()->getBody();
    }

    /**
     * We want to minimize mutation of state, therefore,
     * these methods only exist to ensure contract compliance.
     */
    public function withMethod($method): self
    {
        return $this;
    }

    public function withUri(UriInterface $uri, $preserveHost = false): self
    {
        return $this;
    }

    public function withRequestTarget($requestTarget): self
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
