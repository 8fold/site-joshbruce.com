<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter as PsrEmitter;

class Emitter
{
    public static function emitWithResponse(
        int $status,
        array $headers,
        string $body = ''
    ): void
    {
        $factory = new PsrFactory();
        $stream  = $factory->createStream($body);
        $response = new PsrResponse($status, $headers, $stream);
        self::emit($response);
    }

    public static function emitWithResponseFile(
        int $status,
        array $headers,
        string $file
    )
    {
        $factory = new PsrFactory();
        $stream  = $factory->createStreamFromFile($file);
        $response = new PsrResponse($status, $headers, $stream);
        self::emit($response);
    }

    public static function emit(PsrResponse $response): void
    {
        $emitter = new PsrEmitter();
        $emitter->emit($response);
    }
}
