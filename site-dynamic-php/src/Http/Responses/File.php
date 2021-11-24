<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

class File
{
    public static function at(string $filePath, string $contentType): File
    {
        return new File($filePath, $contentType);
    }

    public static function respondTo(
        string $filePath,
        string $contentType
    ): File {
        return new File($filePath, $contentType);
    }

    final private function __construct(
        private string $filePath,
        private string $contentType
    ) {
    }

    public function statusCode(): int
    {
        return 200;
    }

    public function headers(): array
    {
        // TODO: cache-control - /assets should be different than /media
        return [
            'Content-type' => $this->contentType
        ];
    }

    public function stream(): StreamInterface
    {
        return Stream::create(
            @\fopen($this->filePath, 'r')
        );
    }
}
