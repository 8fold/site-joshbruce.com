<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use JoshBruce\Site\Response;

class Emitter
{
    public static function emit(Response $response): void
    {
        $e = new Emitter($response);
        $e->emitResponse();
        exit;
    }

    private function __construct(private Response $response)
    {
    }

    private function response(): Response
    {
        return $this->response;
    }

    private function emitResponse(): void
    {
        if (headers_sent() === false) {
            $this->emitStatusLine();
            $this->emitHeaders();
        }

        if (strlen($this->response()->getBody()) > 0) {
            $this->emitBody();
        }
    }

    private function statusLine(): string
    {
        return "HTTP/2 {$this->response()->getStatusCode()} " .
            "{$this->response()->getReasonPhrase()}";
    }

    private function emitStatusLine(): void
    {
        header(
            $this->statusLine(),
            replace: true,
            response_code: $this->response()->getStatusCode()
        );
    }

    /**
     * @return array<string|array>
     */
    private function headers(): array
    {
        $b = [];
        foreach ($this->response()->getHeaders() as $header => $value) {
            $h = $header;
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $b[$h] = $value;
        }
        return $b;
    }

    private function emitHeaders(): void
    {
        $headers = $this->headers();
        if (headers_sent() === false) {
            foreach ($headers as $name => $value) {
                if (is_string($value)) {
                    header("{$name}: {$value}", true);
                }
            }
        }
    }

    public function emitBody(): void
    {
        print $this->response()->getBody();
    }
}
