<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Eightfold\HTMLBuilder\Document as HtmlDocument;
use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Server;
use JoshBruce\Site\Content;
use JoshBruce\Site\Response;

class Environment
{
    /**
     * @var Content
     */
    private $content;

    private string $contentRoot = '';

    public static function init(Server $server): Environment
    {
        return new Environment($server);
    }

    public function __construct(private Server $server)
    {
    }

    public function response(): Response
    {
        if ($this->content()->isValid()) {
            return Response::create();
        }

        $markdown = file_get_contents(
            $this->projectRoot() .
            '/500-errors/502.md'
        );

        if (is_bool($markdown)) {
            $markdown = '';
        }

        $meta     = $this->markdownConverter()->getFrontMatter($markdown);
        $title    = $meta['title'];

        return Response::create(
            status: 502,
            headers: [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            body: HtmlDocument::create($title)->body(
                $this->markdownConverter()->convert($markdown)
            )->build()
        );
    }

    public function server(): Server
    {
        return $this->server;
    }

    public function content(): Content
    {
        if ($this->content === null) {
            $this->content = Content::init(
                $this->projectRoot(),
                $this->contentUp(),
                $this->contentFolder(),
                $this->markdownConverter()
            );
        }
        return $this->content;
    }

    public function markdownConverter(): Markdown
    {
        return $this->server()->markdownConverter();
    }

    private function contentUp(): int
    {
        return $this->server()->contentUp();
    }

    private function contentFolder(): string
    {
        return $this->server()->contentFolder();
    }

    private function projectRoot(): string
    {
        return $this->server()->projectRoot();
    }
}
