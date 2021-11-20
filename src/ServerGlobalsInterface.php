<?php

declare(strict_types=1);

namespace JoshBruce\Site;

interface ServerGlobalsInterface
{
    public static function init(): ServerGlobalsInterface;

    public function withRequestUri(string $uri): ServerGlobalsInterface;

    public function withRequestMethod(string $method): ServerGlobalsInterface;

    public function appEnv(): string;

    public function appUrl(): string;

    public function isMissingRequiredValues(): bool;
}
