<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Whoops\Run as ErrorHandler;
use Whoops\Handler\PrettyPageHandler as ErrorPageHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7Server\ServerRequestCreator as PsrServerRequestCreator;

use JoshBruce\Site\ServerGlobals;
use JoshBruce\Site\FileSystemInterface;

use JoshBruce\Site\File;

/**
 * Immutable class for server requests
 */
class HttpRequest
{
    private RequestInterface $psrRequest;

    private string $localPath = '';

    public static function with(
        ServerGlobals $serverGlobals,
        FileSystemInterface $in
    ): HttpRequest {
        return new HttpRequest($serverGlobals, $in);
    }

//     public static function fromGlobals(): HttpRequest
//     {
//         if ($fileSystem === null) {
//             $fileSystem = new FileSystemInterface();
//         }
//
//         return new HttpRequest();
//     }
//
//     // public static function for(FileSystemInterface $contentFolder): HttpRequest
//     // {
//     //     return new HttpRequest($contentFolder, $serverGlobals);
//     // }
//
    private function __construct(
        private ServerGlobals $serverGlobals,
        private FileSystemInterface $fileSystem
    ) {
        if ($this->serverGlobals()->appEnv() !== 'production') {
            // use Whoops! for error display
            $errorHandler = new ErrorHandler();
            $errorHandler->pushHandler(
                new ErrorPageHandler()
            );
            $errorHandler->register();
        }
    }

    public function isMissingRequiredValues(): bool
    {
        return $this->serverGlobals()->isMissingRequiredValues();
    }

    public function isUnsupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->psrRequest()->getMethod());
        $isSupported   =  in_array($requestMethod, $this->supportedMethods());

        return ! $isSupported;
    }

    public function isNotFound(): bool
    {
        $isFound = file_exists($this->localPath()) and
            is_file($this->localPath());
        return ! $isFound;
    }

    public function localFile(): File
    {
        return File::at(localPath: $this->localPath(), in: $this->fileSystem());
    }

    public function isFile(): bool
    {
        return str_contains($this->possibleFileName(), '.');
    }

    public function isSitemap(): bool
    {
        return $this->possibleFileName() === 'sitemap.xml';
    }

    public function isNotSitemap(): bool
    {
        return ! $this->isSitemap();
    }

    public function fileSystem(): FileSystemInterface
    {
        return $this->fileSystem;
    }

    private function localPath(): string
    {
        if (empty($this->localPath)) {
            $possibleFileName = $this->possibleFileName();
            $relativePath = $this->psrPath();
            if (empty($possibleFileName)) {
                $relativePath = $this->psrPath() . '/content.md';
            }

            if (! str_starts_with($relativePath, '/')) {
                $relativePath = "/{$relativePath}";
            }

            $root = $this->fileSystem()->publicRoot();

            $this->localPath = "{$root}{$relativePath}";
        }
        return $this->localPath;
    }

    private function possibleFileName(): string
    {
        $parts = explode('/', $this->psrPath());
        $lastPart = array_slice($parts, -1);
        $possibleFileName = array_shift($lastPart);
        if (
            $possibleFileName === null or
            ! str_contains($possibleFileName, '.')
        ) {
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

    private function serverGlobals(): ServerGlobals
    {
        return $this->serverGlobals;
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

    private function psrPath(): string
    {
        $psrPath = $this->psrRequest()->getUri()->getPath();
        if ($psrPath === '/') {
            $psrPath = '';
        }
        return $psrPath;
    }
//
//     private function uri(): UriInterface
//     {
//         return $this->psrRequest()->getUri();
//     }
}
