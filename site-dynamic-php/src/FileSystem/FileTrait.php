<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use SplFileInfo;

use JoshBruce\SiteDynamic\FileSystem\FileInterface;
use JoshBruce\SiteDynamic\FileSystem\FileMimetype;

trait FileTrait
{
    private SplFileInfo $fileInfo;

    public static function at(string $localPath, string $root): FileInterface
    {
        return new static($localPath, $root);
    }

    private function __construct(
        private string $localPath,
        private string $root
    ) {
    }

    public function mimetype(): FileMimetype
    {
        return FileMimetype::with(
            mime_content_type($this->localPath),
            $this->extension()
        );
    }

    private function extension(): string
    {
        return $this->fileInfo()->getExtension();
    }

    private function fileInfo(): SplFileInfo
    {
        if (! isset($this->fileInfo)) {
            $this->fileInfo = new SplFileInfo($this->localPath);
        }
        return $this->fileInfo;
    }
}
