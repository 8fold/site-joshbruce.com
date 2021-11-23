<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

// use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Stream;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\File as LocalFile;

class File
{
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
