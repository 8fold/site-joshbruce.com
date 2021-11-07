<?php
//
// declare(strict_types=1);
//
// namespace JoshBruce\Site;
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
// class ServerGlobals
// {
//     private array $globals = [];
//
//     public static function init(): ServerGlobals
//     {
//         return new ServerGlobals();
//     }
//
//     public function __construct()
//     {
//     }
//
//     public function appEnv(): string
//     {
//         if ($this->hasAppEnv()) {
//             $globals = $this->globals();
//             return $globals['APP_ENV'];
//         }
//         return '';
//     }
//
//     public function appEnvIsNot(): bool
//     {
//         return $this->appEnv() !== 'production';
//     }
//
//     public function hasAppEnv(): bool
//     {
//         return array_key_exists('APP_ENV', $this->globals());
//     }
//
//     public function isMissingAppEnv(): bool
//     {
//         return ! $this->hasAppEnv();
//     }
//
//     private function globals(): array
//     {
//         return $_SERVER;
//     }
// }
