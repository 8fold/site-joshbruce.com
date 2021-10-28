<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

class Server
{
    /**
     * @param  array<string, string> $serverGlobals
     */
    public static function init(array $serverGlobals): Server
    {
        return new Server(serverGlobals: $serverGlobals);
    }

    /**
     * @param array<string, string> $serverGlobals
     */
    public function __construct(private array $serverGlobals)
    {
    }

    public function isMissingRequiredValues(): bool
    {
        $required = [
            'APP_ENV',
            'CONTENT_UP',
            'CONTENT_FOLDER',
            'REQUEST_SCHEME',
            'HTTP_HOST',
            'REQUEST_URI'
        ];

        $hasRequired = true;
        foreach ($required as $key) {
            if (! array_key_exists($key, $this->serverGlobals)) {
                return true;
            }
        }

        if ($this->serverGlobals['APP_ENV'] !== 'production') {
            $erroHandler = new Run();
            $erroHandler->pushHandler(new PrettyPageHandler());
            $erroHandler->register();
        }

        return false;
    }

    public function contentUp(): int
    {
        return intval($this->serverGlobals['CONTENT_UP']);
    }

    public function contentFolder(): string
    {
        return strval($this->serverGlobals['CONTENT_FOLDER']);
    }
}
