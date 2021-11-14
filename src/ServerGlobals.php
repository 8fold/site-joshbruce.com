<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class ServerGlobals
{
    /**
     * @var array<string, int|string>
     */
    private array $globals = [];

    public static function init(): ServerGlobals
    {
        return new ServerGlobals();
    }

    private function __construct()
    {
        $this->globals = $_SERVER;
    }

    public function withRequestUri(string $uri): ServerGlobals
    {
        $this->globals = [];

        $_SERVER['REQUEST_URI'] = $uri;
        return $this;
    }

    public function requestUri(): string
    {
        $globals = $this->globals();
        return strval($globals['REQUEST_URI']);
    }

    public function withRequestMethod(string $method): ServerGlobals
    {
        $this->globals = [];

        $_SERVER['REQUEST_METHOD'] = $method;
        return $this;
    }

    public function requestMethod(): string
    {
        $globals = $this->globals();
        return strval($globals['REQUEST_METHOD']);
    }

    public function isMissingRequiredValues(): bool
    {
        return ! $this->hasRequiredValues();
    }

    private function hasRequiredValues(): bool
    {
        $globals = $this->globals();
        return array_key_exists('APP_ENV', $globals) and
            array_key_exists('APP_URL', $globals);
    }

    public function appEnv(): string
    {
        if ($this->hasRequiredValues()) {
            $globals = $this->globals();
            return strval($globals['APP_ENV']);
        }
        return '';
    }

    public function appUrl(): string
    {
        if ($this->hasRequiredValues()) {
            $globals = $this->globals();
            return strval($globals['APP_URL']);
        }
    }

    /**
     * @return array<string, int|string>
     */
    private function globals(): array
    {
        if (count($this->globals) === 0) {
            $this->globals = $_SERVER;
        }
        return $this->globals;
    }
}
