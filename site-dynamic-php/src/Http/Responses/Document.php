<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

class Document
{
    public static function respondTo(
        PlainTextFile $file,
        Environment $environment
    ): Document {
        return new Document($file, $environment);
    }

    final private function __construct(
        private PlainTextFile $file,
        private Environment $environment
    ) {
    }

    public function statusCode(): int
    {
        return 200;
    }

    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        return Stream::create(
            HtmlDefault::create(
                'Josh Bruceʼs personal site',
                '',
                Element::main(
                    Markdown::markdownConverter()->convert(
                        $this->file->content()
                    )
                ),
                $this->environment
            )
        );
    }
}
