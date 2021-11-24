<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\FileSystem\FileInterface;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

class File
{
    public static function respondTo(
        FileInterface $file,
        Environment $environment,
        ServerRequestInterface $request
    ): File {
        return new File($file, $environment, $request);
    }

    final private function __construct(
        private FileInterface $file,
        private Environment $environment,
        private ServerRequestInterface $request
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
            'Content-type' => $this->file->mimetype()->interpreted()
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
