<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Whoops\Run as ErrorHandler;
use Whoops\Handler\PrettyPageHandler as ErrorPageHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7Server\ServerRequestCreator as PsrServerRequestCreator;
// use Nyholm\Psr7\Response as PsrResponse;
//
// use JoshBruce\Site\ServerGlobals;
// use JoshBruce\Site\HttpResponse;
// use JoshBruce\Site\FileSystem;

use JoshBruce\Site\File;

/**
 * Immutable class for server requests
 */
class HttpRequest
{
    private RequestInterface $psrRequest;

    private string $localPath = '';

    public static function fromGlobals(): HttpRequest
    {
        return new HttpRequest();
    }

    private function __construct()
    {
    }
//
//     public function response(): HttpResponse
//     {
//     }
//
    public function isMissingRequiredValues(): bool
    {
        if ($this->serverGlobals()->isMissingAppEnv()) {
            return true;
        }

        if ($this->serverGlobals()->appEnvIsNot('production')) {
            // use Whoops! for error display
            $errorHandler = new ErrorHandler();
            $errorHandler->pushHandler(
                new ErrorPageHandler()
            );
            $errorHandler->register();
        }
        return false;
    }

    public function isUnsupportedMethod(): bool
    {
        return ! $this->isSupportedMethod();
    }

    public function isNotFound(): bool
    {
        return ! $this->isFound();
    }

    public function isFile(): bool
    {
        return str_contains($this->possibleFileName(), '.');
    }

    public function localFile(): File
    {
        return File::at(localPath: $this->localPath());
    }

    private function isFound(): bool
    {
        return file_exists($this->localPath()) and is_file($this->localPath());
    }

    private function localPath(): string
    {
        if (empty($this->localPath)) {
            $possibleFileName = $this->possibleFileName();
            $relativePath = $this->uriPath();
            if (empty($possibleFileName)) {
                $relativePath = $this->uriPath() . '/content.md';
            }

            $root = FileSystem::contentRoot();

            $this->localPath = "{$root}/public{$relativePath}";
        }
        return $this->localPath;
    }

    private function possibleFileName(): string
    {
        $parts = explode('/', $this->uriPath());
        $lastPart = array_slice($parts, -1);
        $possibleFileName = array_shift($lastPart);
        if ($possibleFileName === null) {
            return '';
        }
        return $possibleFileName;
    }

    /**
     * @return string[]
     */
    private function supportedMethods(): array
    {
        return ['GET'];
    }

    private function isSupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->psrRequest()->getMethod());
        return in_array($requestMethod, $this->supportedMethods());
    }

    private function serverGlobals(): ServerGlobals
    {
        return ServerGlobals::init();
    }

    private function psrRequest(): RequestInterface
    {
        if (! isset($this->psrRequest)) {
            $psr17Factory = new PsrFactory();
            $creator      = new PsrServerRequestCreator(
                $psr17Factory,
                $psr17Factory,
                $psr17Factory,
                $psr17Factory
            );

            $this->psrRequest = $creator->fromGlobals();
        }
        return $this->psrRequest;
    }

    private function uriPath(): string
    {
        $uriPath = $this->uri()->getPath();
        if ($uriPath === '/') {
            $uriPath = '';
        }
        return $uriPath;
    }

    private function uri(): UriInterface
    {
        return $this->psrRequest()->getUri();
    }
}
