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

    public function isUsingUnsupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->serverGlobals['REQUEST_METHOD']);
        return ! in_array($requestMethod, $this->supportedMethods());
    }

    public function isRequestingFile(): bool
    {
        return strpos($this->requestUri(), '.') > 0;
    }

    /**
     * @return string[] [description]
     */
    public function supportedMethods(): array
    {
        return ['GET'];
    }

    public function contentUp(): int
    {
        return intval($this->serverGlobals['CONTENT_UP']);
    }

    public function contentFolder(): string
    {
        return strval($this->serverGlobals['CONTENT_FOLDER']);
    }

    public function filePathForRequest(): string
    {
        if ($this->isRequestingFile()) {
            $folderMap = [
                '/css'    => '/.assets/styles',
                '/js'     => '/.assets/scripts',
                '/assets' => '/.assets'
            ];

            $parts = explode('/', $this->requestUri());
            $parts = array_filter($parts);
            $first = array_shift($parts);

            $folderMapKey  = '/' . $first;

            if (array_key_exists($folderMapKey, $folderMap)) {
                $replace = $folderMap[$folderMapKey];

                return str_replace(
                    $folderMapKey,
                    $replace,
                    $this->requestUri()
                );
            }
            return $this->requestUri();
        }
        return $this->requestUri() . '/content.md';
    }

    public function requestUri(): string
    {
        if ($this->serverGlobals['REQUEST_URI'] === '/') {
            return '';
        }
        return $this->serverGlobals['REQUEST_URI'];
    }
}
