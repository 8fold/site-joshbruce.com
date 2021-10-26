<?php

declare(strict_types=1);

namespace JoshBruce\Site;

/**
 * This response class is not meant to be reusable in general projects, like
 * those implementing the full PSR-7 recommendation. Instead, it is made
 * specifically for joshbruce.com.
 */
class Response
{
    public static function createStream(
        int $status = 200,
        array $headers = [],
        string $body = ''
    ): Response {

    }
    /**
     * Not part of PSR-7
     *
     * @param array<string, array<int, string>> $headers
     *
     */
    public static function create(
        int $status = 200,
        array $headers = [],
        $body = '',
        string $version = '2'
    ): Response {
        return new Response($status, $headers, $body, $version);
    }

    /**
     * @param array<string, array<int, string>> $headers
     */
    public function __construct(
        private int $status = 200,
        private array $headers = [],
        private $body = '',
        private string $version = '2'
    ) {
    }

    public function isOk(): bool
    {
        return $this->getStatusCode() === 200;
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getReasonPhrase(): string
    {
        return $this->reason;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
