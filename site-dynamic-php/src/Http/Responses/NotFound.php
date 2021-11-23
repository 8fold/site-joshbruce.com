<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

class NotFound
{
    public static function respondTo(
        RequestInterface $request
    ): NotFound {
        return new NotFound($request);
    }

    final private function __construct(private RequestInterface $request)
    {
    }

    public function statusCode(): int
    {
        return 404;
    }

    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        return Stream::create(
            HtmlDefault::create(
                'Not found',
                '',
                Element::main(
                    Markdown::markdownConverter()->convert(
                        PlainTextFile::at(
                            // @todo: Add to list of required content
                            Finder::publicRoot() . '/error-404.md',
                            Finder::publicRoot()
                        )->content()
                    )
                )
            )
        );
    }
}
