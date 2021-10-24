<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Dotenv\Dotenv;

use Eightfold\HTMLBuilder\Document as HtmlDocument;

use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Http\Response;

/**
 * Verifies the environment is set up in a way that it can handle respnses.
 *
 * Failure will exit early and send a response to the client.
 */
class Environment
{
    /**
     * @param array<string, array<int, string>|string|int> $serverGlobals
     */
    public static function init(array $serverGlobals): Environment
    {
        return new Environment($serverGlobals);
    }

    /**
     * @param array<string, array<int, string>|string|int> $serverGlobals
     */
    public function __construct(private array $serverGlobals)
    {
    }

    public function requestUri(): string
    {
        // TODO: make sure this is part of a valid setup
        $uri = $this->serverGlobals['REQUEST_URI'];
        if (is_string($uri)) {
            return $uri;
        }
        return '';
    }

    public function isVerified(): bool
    {
        return $this->response()->getStatusCode() === 200;
    }

    public function isNotVerified(): bool
    {
        return ! $this->isVerified();
    }

    public function response(): Response
    {
        if (! $this->hasRequiredVariables() or ! $this->hasValidContent()) {
            $status = 500;
            $reason = 'Internal server error';
            $details = '(environment)';
            if ($this->hasRequiredVariables() and ! $this->hasValidContent()) {
                $status = 502;
                $reason = 'Bad gateway';
                $details = '(content)';
            }

            $headers = [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ];

            $content = file_get_contents($this->publicFolder() . '/500.md');
            $replacements = [
                '%status%'  => $status,
                '%reason%'  => $reason,
                '%details%' => $details
            ];
            $search  = array_keys($replacements);
            $replace = array_values($replacements);

            $markdown = str_replace($search, $replace, $content);

            $m = Markdown::create()->minified();

            $meta = $m->getFrontMatter($markdown);
            $title = 'Server error';
            if (array_key_exists('title', $meta)) {
                $title = $meta['title'];
            }

            $body = HtmlDocument::create($title)->body(
                $m->convert($markdown)
            )->build();

            return new Response(
                $status,
                headers: $headers,
                body: $body,
                reason: $reason
            );
        }
        return new Response(200);
    }

    private function hasRequiredVariables(): bool
    {
        return array_key_exists('CONTENT_UP', $this->serverGlobals) and
            array_key_exists('CONTENT_FOLDER', $this->serverGlobals);
    }

    private function contentUp(): int
    {
        if ($this->hasRequiredVariables()) {
            return intval($this->serverGlobals['CONTENT_UP']);
        }
        return 0;
    }

    private function contentFolder(): string
    {
        if ($this->hasRequiredVariables()) {
            return strval($this->serverGlobals['CONTENT_FOLDER']);
        }
        return '';
    }

    private function hasValidContent(): bool
    {
        return file_exists($this->contentRoot()) and
            is_dir($this->contentRoot());
    }

    public function contentRoot(): string
    {
        if (! $this->hasRequiredVariables()) {
            return '';
        }

        $contentStart = $this->projectRoot();

        $contentParts = explode('/', $contentStart);
        $contentUp    = $this->contentUp();

        if (is_int($contentUp) and $contentUp > 0) {
            $contentParts = array_slice($contentParts, 0, -1 * $contentUp);
        }
        $contentFolder = explode('/', $this->contentFolder());
        $contentFolder = array_filter($contentFolder);
        $contentParts  = array_merge($contentParts, $contentFolder);

        return implode('/', $contentParts);
    }

    private function publicFolder(): string
    {
        return $this->projectRoot() . '/public';
    }

    private function projectRoot(): string
    {
        $start = __DIR__;
        $parts = explode('/', $start);
        $parts = array_slice($parts, 0, -1);
        return implode('/', $parts);
    }
}
