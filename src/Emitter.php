<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class Emitter
{
    public static function create(
        int $statusCode,
        string $statusMessage,
        string $details = ''
    ): Emitter {
        return new Emitter($statusCode, $statusMessage, $details);
    }

    public function __construct(
        private int $statusCode,
        private string $statusMessage,
        private string $details = ''
    ) {
    }

    public function statusLine(): string
    {
        return "HTTP/2 {$this->statusCode} {$this->statusMessage}";
    }

    public function emitStatusLine(): void
    {
        header(
            $this->statusLine(),
            replace: true,
            response_code: $this->statusCode
        );
    }
}
