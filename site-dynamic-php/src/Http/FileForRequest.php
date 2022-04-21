<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Message\ServerRequestInterface;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class FileForRequest
{
    private string $requestPath = '';

    public static function at(
        ServerRequestInterface $request,
        Environment $environment
    ): File|PlainTextFile|false {
        return (new static($request, $environment))->getFile();
    }

    final private function __construct(
        private ServerRequestInterface $request,
        private Environment $environment
    ) {
    }

    private function getFile(): File|PlainTextFile|false
    {
        if ($this->isRequestingXml()) {
            $file = $this->handleXml();
            return ($file->notFound()) ? false : $file;

        } elseif ($this->isRequestingFile()) {
            $file = $this->handleFile();
            return ($file->notFound()) ? false : $file;

        }
        return $this->handleContent();
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function request(): ServerRequestInterface
    {
        return $this->request;
    }

    private function requestPath(): string
    {
        if (strlen($this->requestPath) === 0) {
            $this->requestPath = $this->request()->getUri()->getPath();
        }
        return $this->requestPath;
    }

    private function isRequestingXml(): bool
    {
        return str_ends_with($this->requestPath(), '.xml');
    }

    private function handleXml(): PlainTextFile
    {
        $publicPath = $this->environment()->contentPublic() .
            $this->requestPath();

        $file = PlainTextFile::at(
            $publicPath,
            $this->environment()->contentPublic()
        );

        if ($file->notFound()) {
            $privatePath = $this->environment()->contentPrivate() .
                $this->requestPath();

            $file = PlainTextFile::at(
                $privatePath,
                $this->environment()->contentPrivate()
            );

        }

        return $file;
    }

    private function isRequestingFile(): bool
    {
        return str_contains($this->requestPath(), '.') and
            ! $this->isRequestingXml();
    }

    private function handleFile(): File
    {
        $publicPath = $this->environment()->contentPublic() .
            $this->requestPath();

        $file = File::at(
            $publicPath,
            $this->environment()->contentPublic()
        );

        if ($file->notFound()) {
            $privatePath = $this->environment()->contentPrivate() .
                $this->requestPath();

            $file = File::at(
                $privatePath,
                $this->environment()->contentPrivate()
            );
        }

        return $file;
    }

    private function handleContent(): PlainTextFile
    {
        $publicPath = $this->environment()->contentPublic() .
            $this->requestPath() .
            $this->environment()->contentFilename();

        $file = PlainTextFile::at(
            $publicPath,
            $this->environment()->contentPublic()
        );

        return $file;
    }
}
