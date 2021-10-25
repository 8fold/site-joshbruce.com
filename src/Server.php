<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use ArrayAccess;

use Dotenv\Dotenv;

use Eightfold\HTMLBuilder\Document as HtmlDocument;
use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Response;

/**
 * Object wrapper for $_SERVER globals.
 *
 * @implements \ArrayAccess<string, int|string>
 */
class Server implements ArrayAccess
{
    private const REQUIRED = [
        'APP_ENV',
        'CONTENT_UP',
        'CONTENT_FOLDER'
    ];

    /**
     * @var Markdown
     */
    private $markdownConverter;

    private string $projectRoot = '';

    /**
     * @param array<string, int|string> $serverGlobals
     */
    public static function init(array $serverGlobals): Server
    {
        return new Server($serverGlobals);
    }

    /**
     * @param array<string, int|string> $serverGlobals
     */
    public function __construct(private array $serverGlobals)
    {
    }

    public function response(): Response
    {
        if ($this->hasRequiredValues()) {
            return Response::create(200);
        }

        $markdown = file_get_contents(
            $this->projectRoot() .
            '/500-errors/500.md'
        );

        if (is_bool($markdown)) {
            $markdown = '';
        }

        $meta  = $this->markdownConverter()->getFrontMatter($markdown);
        $title = $meta['title'];

        return Response::create(
            500,
            body: HtmlDocument::create($title)->body(
                $this->markdownConverter()->convert($markdown)
            )->build(),
            headers: [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            reason: 'Internal server error'
        );
    }

    public function contentUp(): int
    {
        return intval($this->offsetGet('CONTENT_UP'));
    }

    public function contentFolder(): string
    {
        return strval($this->offsetGet('CONTENT_FOLDER'));
    }

    public function requestUri(): string
    {
        return strval($this->offsetGet('REQUEST_URI'));
    }

    public function projectRoot(): string
    {
        if (strlen($this->projectRoot) === 0) {
            $start = __DIR__;
            $parts = explode('/', $start);
            $parts = array_slice($parts, 0, -1);
            $this->projectRoot = implode('/', $parts);
        }
        return $this->projectRoot;
    }

    public function markdownConverter(): Markdown
    {
        if (! isset($this->markdownConverter)) {
            $this->markdownConverter = Markdown::create()->minified()
                ->smartPunctuation();
        }
        return $this->markdownConverter;
    }

    private function hasRequiredValues(): bool
    {
        foreach (static::REQUIRED as $offset) {
            if (! $this->offsetExists($offset)) {
                return false;
            }
        }
        return true;
    }

    /**
     * ArrayAccess methods
     */
    public function offsetExists(mixed $offset): bool
    {
        return (
            is_string($offset) and
            array_key_exists($offset, $this->serverGlobals)
        );
    }

    public function offsetGet(mixed $offset): string|int
    {
        if ($this->offsetExists($offset)) {
            return $this->serverGlobals[$offset];
        }
        return '';
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
    }

    public function offsetUnset(mixed $offset): void
    {
    }
}
