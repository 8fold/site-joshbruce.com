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
    public static function init(
        array $serverGlobals,
        string $projectRoot
    ): Server {
        return new Server(
            serverGlobals: $serverGlobals,
            projectRoot: $projectRoot
        );
    }

    /**
     * @param array<string, string> $serverGlobals
     */
    public function __construct(
        private array $serverGlobals,
        private string $projectRoot
    ) {
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

        foreach ($required as $key) {
            if (! array_key_exists($key, $this->serverGlobals)) {
                return true;
            }

            if ($key === 'REQUEST_URI') {
                $uri = $this->serverGlobals['REQUEST_URI'];
                $parts = explode('?', $uri);
                $this->serverGlobals['REQUEST_URI'] = array_shift($parts);
            }
        }

        if ($this->serverGlobals['APP_ENV'] !== 'production') {
            $erroHandler = new Run();
            $erroHandler->pushHandler(new PrettyPageHandler());
            $erroHandler->register();
        }

        return false;
    }

    public function isRequestingUnsupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->serverGlobals['REQUEST_METHOD']);
        return ! in_array($requestMethod, $this->supportedMethods());
    }

    public function isRequestingFile(): bool
    {
        return strlen($this->requestFileName()) > 0;
    }

    /**
     * @return string[]
     */
    public function supportedMethods(): array
    {
        return ['GET'];
    }


    public function contentRoot(): string
    {
        $projectParts  = explode('/', $this->projectRoot);
        $contentUp     = intval($this->serverGlobals['CONTENT_UP']);
        $contentFolder = strval($this->serverGlobals['CONTENT_FOLDER']);

        if (is_int($contentUp) and $contentUp > 0) {
            $projectParts = array_slice($projectParts, 0, -1 * $contentUp);
        }

        $contentParts = explode('/', $contentFolder); // allow for subfolders
        $contentParts = array_filter($contentParts); // remove empty value
        $contentParts = array_merge($projectParts, $contentParts);

        if (
            $this->isRequestingFile() and
            in_array($this->requestFileName(), $contentParts)
        ) {
            array_pop($contentParts);
        }

        return implode('/', $contentParts);
    }

    public function requestFileName(): string
    {
        $path  = $this->requestUri();
        $parts = explode('/', $path);

        $possibleFileName = array_pop($parts);
        if (
            $possibleFileName !== null and
            ! str_starts_with($possibleFileName, '.') and
            $fileNameParts = array_filter(explode('.', $possibleFileName)) and
            count($fileNameParts) > 1
        ) {
            return $possibleFileName;
        }
        return '';
    }

    public function requestUriWithoutFileName(): string
    {
        if ($this->isRequestingFile()) {
            $potential = '/' . $this->requestFileName();
            return str_replace($potential, '', $this->requestUri());
        }
        return $this->requestUri();
    }

    public function domain(): string
    {
        $scheme     = $this->serverGlobals['REQUEST_SCHEME'];
        $serverName = $this->serverGlobals['HTTP_HOST'];
        return $scheme . '://' . $serverName;
    }

    private function requestUri(): string
    {
        if ($this->serverGlobals['REQUEST_URI'] === '/') {
            return '';
        }
        return $this->serverGlobals['REQUEST_URI'];
    }
}
