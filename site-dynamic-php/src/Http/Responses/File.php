<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class File
{
    use ResponseCycleTrait;

    public function statusCode(): int
    {
        return 200;
    }

    public function headers(): array
    {
        // TODO: cache-control - /assets should be different than /media
        return [
            'Content-type' => [
                $this->file->mimetype()->interpreted()
            ]
        ];
    }

    public function stream(): StreamInterface
    {
        if ($this->request->getMethod() === 'HEAD') {
            return Stream::create('');
        }
        return Stream::create(
            @\fopen($this->file->path(), 'r')
        );
    }
}
