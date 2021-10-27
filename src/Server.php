<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use ArrayAccess;

use Dotenv\Dotenv;

use Eightfold\HTMLBuilder\Document as HtmlDocument;

use JoshBruce\Site\Content;
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

    // private string $projectRoot = '';

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
            return Response::create(status: 200);
        }

        // Custom content instance required
        //
        // This somewhat unreadable one-liner basically creates a fully qualified
        // path to the root of the project, without using relative syntax
        $projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

        $content = Content::init($projectRoot, 0, '/500-errors')->for('/500.md');
        return Response::create(
            status: 500,
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

    public function contentUp(): int
    {
        return intval($this->offsetGet('CONTENT_UP'));
    }

    public function contentFolder(): string
    {
        return strval($this->offsetGet('CONTENT_FOLDER'));
    }

    // public function projectRoot(): string
    // {
    //     if (strlen($this->projectRoot) === 0) {
    //         $start = __DIR__;
    //         $parts = explode('/', $start);
    //         $parts = array_slice($parts, 0, -1);
    //         $this->projectRoot = implode('/', $parts);
    //     }
    //     return $this->projectRoot;
    // }

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
