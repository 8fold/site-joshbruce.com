<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class ServerGlobals
{
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

    public function isMissingAppEnv(): bool
    {
        return ! $this->hasAppEnv();
    }

    private function appEnv(): string
    {
        if ($this->hasAppEnv()) {
            $globals = $this->globals();
            return strval($globals['APP_ENV']);
        }
        return '';
    }

    private function hasAppEnv(): bool
    {
        return array_key_exists('APP_ENV', $this->globals());
    }

    /**
     * @return array<string, int|string>
     */
    private function globals(): array
    {
        return $_SERVER;
    }
}
