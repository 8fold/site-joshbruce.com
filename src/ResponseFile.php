<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\Site\Emitter;

/**
 * This response class is not meant to be reusable in general projects, like
 * those implementing the full PSR-7 recommendation. Instead, it is made
 * specifically for joshbruce.com.
 */
class ResponseFile
{
    /**
     * @var PsrResponse
     */
    private $psrResponse;

    /**
     * Not part of PSR-7
     *
     * @param array<string, array<int, string>|string> $headers
     *
     */
    public static function create(
        int $status = 200,
        array $headers = [],
        string $file = ''
    ): ResponseFile {
        return new ResponseFile($status, $headers, $file);
    }

    /**
     * @param array<string, array<int, string>|string> $headers
     */
    public function __construct(
        private int $status = 200,
        private array $headers = [],
        private string $file = ''
    ) {
    }

    private function psrResponse(): PsrResponse
    {
        if ($this->psrResponse === null) {
            $factory = new PsrFactory();
            $stream  = $factory->createStreamFromFile($this->file);
            $this->psrResponse = new PsrResponse(
                status: $this->status,
                headers: $this->headers,
                body: $stream,
                version: '2'
            );
        }
        return $this->psrResponse;
    }

    public function getStatusCode(): int
    {
        return $this->psrResponse()->getStatusCode();
    }

    public function isOk(): bool
    {
        return $this->getStatusCode() === 200;
    }

    public function emit(): void
    {
        Emitter::emit($this->psrResponse());
    }
}
