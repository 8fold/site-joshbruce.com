<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class NotFound
{
    use ResponseCycleTrait;

    public function statusCode(): int
    {
        return 404;
    }

    /**
     * @return array<string, string|string[]>
     */
    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        if ($this->request->getMethod() === 'HEAD') {
            return Stream::create('');
        }
        return Stream::create(
            HtmlDefault::create(
                'Not found',
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
