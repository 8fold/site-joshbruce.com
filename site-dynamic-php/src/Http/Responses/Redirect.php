<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class Redirect
{
    use ResponseCycleTrait;

    public function statusCode(): int
    {
        $parts = explode(' ', $this->file->redirect(), 2);
        return intval($parts[0]);
    }

    public function headers(): array
    {
        $parts = explode(' ', $this->file->redirect(), 2);
        return [
            'Location' => strval($parts[1])
        ];
    }

    public function stream(): StreamInterface
    {
        return Stream::create('');
    }
}
