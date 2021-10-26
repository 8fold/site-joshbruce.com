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

    private string $projectRoot = '';

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
            return Response::create(status: 200);
        }

        // Custom content instance required
        //
        // This somewhat unreadable one-liner basically creates a fully qualified
        // path to the root of the project, without using relative syntax
        $projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

        $content = Content::init($projectRoot, 0, '/500-errors')->for('/502.md');
        return Response::create(
            status: 502,
            headers: [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            body: HtmlDocument::create(
                $content->title()
            )->body(
                $content->html()
            )->build()
        );
    }

    public function content(): Content
    {
        if ($this->content === null) {
            $this->content = Content::init(
                $this->projectRoot(),
                $this->server()->contentUp(),
                $this->server()->contentFolder()
            );
        }
        return $this->content;
    }

    private function projectRoot(): string
    {
        if (strlen($this->projectRoot) === 0) {
            $start = __DIR__;
            $parts = explode('/', $start);
            $parts = array_slice($parts, 0, -1);
            $this->projectRoot = implode('/', $parts);
        }
        return $this->projectRoot;
    }

    private function server(): Server
    {
        return $this->server;
    }
}
