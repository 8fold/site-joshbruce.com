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

class Redirect
{
    public static function with(
        PlainTextFile $file,
        Environment $environment,
        ServerRequestInterface $request
    ): Redirect {
        return new Redirect($file, $environment, $request);
    }

    final private function __construct(
        private PlainTextFile $file,
        private Environment $environment,
        private ServerRequestInterface $request
    ) {
    }

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
