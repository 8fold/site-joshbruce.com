<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use SplFileInfo;

// use JoshBruce\SiteDynamic\FileSystem\FileInterface;
use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;
use JoshBruce\SiteDynamic\FileSystem\FileMimetype;

trait FileTrait
{
    final private function __construct(
        private SplFileInfo $fileInfo,
        private string $root
    ) {
    }

    public function root(): string
    {
        return $this->root;
    }

    public function isDraft(): bool
    {
        $path = $this->path(full: $false);
    }

    public function path(bool $full = true, bool $omitFilename = false): string
    {
        $realPath = $this->fileInfo()->getRealPath();
        if (! $realPath) {
            return '';
        }

        if ($omitFilename) {
            $parts = explode('/', $realPath);
            $parts = array_slice($parts, 0, -1);
            $realPath = implode('/', $parts);

        }

        if ($full) {
            return $realPath;

        }

        return str_replace($this->root(), '', $realPath);
    }

    public function mimetype(): FileMimetype
    {
        $mimetype = mime_content_type($this->path());
        if (! $mimetype) {
            $mimetype = 'text/plain';
        }

        return FileMimetype::with($mimetype, $this->extension());
    }

    public function canonicalUrl(): string
    {
        return $_SERVER['APP_URL'] . $this->path(full: false, omitFilename: true);
    }

    private function extension(): string
    {
        return $this->fileInfo()->getExtension();
    }

    private function fileInfo(): SplFileInfo
    {
        return $this->fileInfo;
    }
}
