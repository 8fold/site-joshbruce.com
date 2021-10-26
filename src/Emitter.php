<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Response as PsrResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter as PsrEmitter;

class Emitter
{
    public static function emit(PsrResponse $response): void
    {
        $emitter = new PsrEmitter();
        $emitter->emit($response);
    }
}
