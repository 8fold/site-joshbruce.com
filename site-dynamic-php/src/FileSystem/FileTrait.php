<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use SplFileInfo;

use JoshBruce\SiteDynamic\FileSystem\FileInterface;
use JoshBruce\SiteDynamic\FileSystem\FileMimetype;

trait FileTrait
{
    public static function at(string $localPath, string $root): FileInterface
    {
        return static::from(
            new SplFileInfo($localPath),
            $root
        );
    }

    public static function from(
        SplFileInfo $fileInfo,
        string $root
    ): FileInterface {
        return new static($fileInfo, $root);
    }

    private function __construct(
        private SplFileInfo $fileInfo,
        private string $root
    ) {
    }

    public function root(): string
    {
        return $this->root;
    }

    public function path(bool $full = true): string
    {
        $realPath = $this->fileInfo()->getRealPath();
        if ($full) {
            return $realPath;
        }
        return str_replace($this->root(), '', $realPath);
    }

    public function mimetype(): FileMimetype
    {
        return FileMimetype::with(
            mime_content_type($this->path()),
            $this->extension()
        );
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
