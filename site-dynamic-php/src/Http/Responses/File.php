<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;
use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\SiteDynamic\FileSystem\File as LocalFile;

class File
{
    public static function with(
        LocalFile $file,
        ServerRequestInterface $request
    ): static {
        return new static($file, $request);
    }

    final private function __construct(
        private LocalFile $file,
        private ServerRequestInterface $request
    ) {
    }

    public function respond(): ResponseInterface
    {
        return new PsrResponse(
            status: $this->statusCode(),
            headers: $this->headers(),
            body: $this->stream()
        );
    }

    public function statusCode(): int
    {
        return 200;
    }

    /**
     * @return array<string, string|string[]>
     */
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

        $resource = @\fopen($this->file->path(), 'r');
        if (is_resource($resource)) {
            return Stream::create($resource);
        }
        return Stream::create('');
    }
}
