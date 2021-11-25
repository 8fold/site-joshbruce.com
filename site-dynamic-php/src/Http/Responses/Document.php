<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Http\Responses\ResponseCycleTrait;

class Document
{
    use ResponseCycleTrait;

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
        if ($this->request->getMethod() === 'HEAD') {
            return Stream::create('');
        }

        $content = $this->file->content();
        $content = Markdown::processPartials($content, $this->file);
        return Stream::create(
            HtmlDefault::create(
                'Josh Bruceʼs personal site',
                '',
                Element::main(
                    Markdown::markdownConverter()->convert($content)
                ),
                $this->environment
            )
        );
    }
}
