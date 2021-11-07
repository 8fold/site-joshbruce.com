<?php

declare(strict_types=1);

namespace JoshBruce\Site;
//
// // use Whoops\Run;
// // use Whoops\Handler\PrettyPageHandler;
// //
// // use Psr\Http\Message\RequestInterface;
// //
// // use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
// // use Nyholm\Psr7\Response as PsrResponse;
// //
// // use JoshBruce\Site\ServerGlobals;
// // use JoshBruce\Site\HttpResponse;
//
class ServerGlobals
{
//     private array $globals = [];
//
    public static function init(): ServerGlobals
    {
        return new ServerGlobals();
    }
//
//     public function __construct()
//     {
//     }
//
//
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
