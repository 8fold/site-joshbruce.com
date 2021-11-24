<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class UnsupportedMethod
{
    use ResponseCycleTrait;

    public function statusCode(): int
    {
        return 405;
    }

    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        return Stream::create('');
    }
}
