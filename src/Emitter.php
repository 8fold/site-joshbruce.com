<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class Emitter
{
    /**
     * @param array<string|array> $headers
     */
    public static function create(
        int $statusCode,
        string $statusReason,
        array $headers = [],
        string $details = ''
    ): Emitter {
        return new Emitter($statusCode, $statusReason, $headers, $details);
    }

    /**
     * @param array<string|array> $headers
     */
    public function __construct(
        private int $statusCode,
        private string $statusReason,
        private array $headers = [],
        private string $details = ''
    ) {
    }

    public function statusLine(): string
    {
        return "HTTP/2 {$this->statusCode} {$this->statusReason}";
    }

    public function emitStatusLine(): void
    {
        header(
            $this->statusLine(),
            replace: true,
            response_code: $this->statusCode
        );
    }

    /**
     * @return array<string|array>
     */
    public function headers(): array
    {
        $b = [];
        foreach ($this->headers as $header => $value) {
            $h = $header;
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $b[$h] = $value;
        }
        return $b;
    }

    public function emitHeaders(): void
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

    public function body(): string
    {
        if ($this->statusCode === 500 or $this->statusCode === 502) {
            $code   = $this->statusCode;
            $reason = $this->statusReason;

            $details = 'environment';
            if ($this->statusCode === 502) {
                $details = 'content';
            }
            $details = "({$details})";

            return <<<html
                <!doctype html>
                <html>
                    <head>
                        <title>Server error | Josh Bruce's personal site</title>
                    </head>
                    <body>
                        <h1>$code: $reason $details</h1>
                        <p>We're not sure what happened here. Please try again later.</p>
                        <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
                    </body>
                </html>
                html;

        } elseif ($this->statusCode === 404) {
            return <<<html
                <!doctype html>
                <html>
                    <head>
                        <title>Not found | Josh Bruce's personal site</title>
                        <style>
                            h1 {
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <h1>404: Not found</h1>
                        <p>We still haven't found what you're looking for.</p>
                    </body>
                </html>
                html;
        }

        return <<<html
            <!doctype html>
            <html>
                <head>
                    <title>Josh Bruce's personal site</title>
                    <style>
                        h1 {
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <h1>The domain of Josh Bruce</h1>
                    <p>This content was successfully found.</p>
                </body>
            </html>
            html;
    }

    public function emitBody(): void
    {
        print $this->body($this->statusCode);
    }
}
