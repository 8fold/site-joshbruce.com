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

class Request implements RequestInterface
{
    private PsrServerRequestCreator $creator;

    private RequestInterface $psrRequest;

    public static function fromGlobals(Finder $in): Request
    {
        return new static($in);
    }

    final private function __construct(private Finder $finder)
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

    public function finder(): Finder
    {
        return $this->finder;
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

    public function withMethod($method): self
    {
        $this->psrRequest = $this->psrRequest()
            ->withMethod($method);
        return $this;
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
    public function withUri(UriInterface $uri, $preserveHost = false): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withUri($uri, $preserveHost);
        return $this;
    }

    public function withRequestTarget($requestTarget): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withRequestTarget($requestTarget);
        return $this;
    }

    public function withProtocolVersion($version): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withProtocolVersion($version);
        return $this;
    }

    public function withHeader($header, $value): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withHeader($header, $value);
        return $this;
    }

    public function withAddedHeader($header, $value): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withAddedHeader($header, $value);
        return $this;
    }

    public function withoutHeader($header): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withoutHeader($header);
        return $this;
    }

    public function withBody(StreamInterface $body): self
    {
        // $this->psrRequest = $this->psrRequest()
        //     ->withBody($body);
        return $this;
    }
}
