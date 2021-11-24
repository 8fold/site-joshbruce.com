<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

class InternalServerError
{
    public static function respondTo(
        PlainTextFile $file,
        Environment $environment,
        ServerRequestInterface $request
    ): InternalServerError {
        return new InternalServerError($file, $environment, $request);
    }

    final private function __construct(
        private PlainTextFile $file,
        private Environment $environment,
        private ServerRequestInterface $request
    ) {
    }

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
