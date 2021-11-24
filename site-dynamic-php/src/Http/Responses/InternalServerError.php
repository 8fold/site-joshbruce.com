<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class InternalServerError
{
    use ResponseCycleTrait;

    public function statusCode(): int
    {
        return 500;
    }

    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        if ($this->request->getMethod() === 'HEAD') {
            return Stream::create('');
        }
        return Stream::create($this->file->content());
    }
}
