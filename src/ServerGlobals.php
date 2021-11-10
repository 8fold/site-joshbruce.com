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
    }

    public function appEnvIsNot(string $value): bool
    {
        return $this->appEnv() !== $value;
    }

    private function appEnv(): string
    {
        if ($this->hasAppEnv()) {
            $globals = $this->globals();
            return strval($globals['APP_ENV']);
        }
        return '';
    }

    public function isMissingAppEnv(): bool
    {
        return ! $this->hasAppEnv();
    }

    public function isMissingAppUrl(): bool
    {
        return ! $this->hasAppUrl();
    }

    public function appUrl(): string
    {
        if ($this->hasAppUrl()) {
            $globals = $this->globals();
            return strval($globals['APP_URL']);
        }
        return '';
    }

    private function hasAppEnv(): bool
    {
        return array_key_exists('APP_ENV', $this->globals());
    }

    private function hasAppUrl(): bool
    {
        return array_key_exists('APP_URL', $this->globals());
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
