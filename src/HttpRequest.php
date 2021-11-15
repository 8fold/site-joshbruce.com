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

    private File $localFile;

    private string $possibleFileName = '';

    public static function with(
        ServerGlobals $serverGlobals,
        FileSystemInterface $in
    ): HttpRequest {
        return new HttpRequest($serverGlobals, $in);
    }

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

    public function statusCode(): int
    {
        if ($this->serverGlobals()->isMissingRequiredValues()) {
            return 500;

        } elseif ($this->isUnsupportedMethod()) {
            return 405;

        } elseif ($this->isNotFound()) {
            return 404;

        }
        return 200;
    }

    private function isUnsupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->psrRequest()->getMethod());
        $isSupported   =  in_array($requestMethod, $this->supportedMethods());

        return ! $isSupported;
    }

    private function isNotFound(): bool
    {
        $isFound = file_exists($this->localPath()) and
            is_file($this->localPath());
        return ! $isFound;
    }

    public function localFile(): File
    {
        if (! isset($this->localFile)) {
            $this->localFile = File::at(
                localPath: $this->localPath(),
                in: $this->fileSystem()
            );
        }
        return $this->localFile;
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
            $relativePath = $this->psrPath();
            if (empty($this->possibleFileName())) {
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
        if (strlen($this->possibleFileName) === 0) {
            $parts = explode('/', $this->psrPath());
            $lastPart = array_slice($parts, -1);
            $possibleFileName = array_shift($lastPart);
            if (
                $possibleFileName === null or
                ! str_contains($possibleFileName, '.')
            ) {
                return '';
            }

            $this->possibleFileName = $possibleFileName;
        }
        return $this->possibleFileName;
    }

    /**
     * @return string[]
     */
    private function supportedMethods(): array
    {
        return ['GET'];
    }

    public function serverGlobals(): ServerGlobals
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
}
