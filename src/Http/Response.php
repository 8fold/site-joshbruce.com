<?php

declare(strict_types=1);

namespace JoshBruce\Site\Http;

/**
 * This response class is not meant to be reusable in general projects, like
 * those implementing the full PSR-7 recommendation. Instead, it is made
 * specifically for joshbruce.com.
 */
class Response
{
    /**
     * Not part of PSR-7
     */
    public static function create(
        int $status = 200,
        array $headers = [],
        string $body = '',
        string $version = '2',
        string $reason = ''
    )
    {
        return new Response($status, $headers, $body, $version, $reason);
    }

    public function __construct(
        private int $status = 200,
        private array $headers = [],
        private string $body = '',
        private string $version = '2',
        private string $reason = ''
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getReasonPhrase(): string
    {
        return $this->reason;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }
}
