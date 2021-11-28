<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic;

use SplFileInfo;

class Environment
{
    private const CONTENT_FILENAME = 'content.md';

    private const FILE_SEPARATOR = '/';

    private SplFileInfo $publicRootFileInfo;

    public static function with(
        string $publicRoot,
        string $appUrl,
        string $appEnv
    ): Environment {
        return new Environment($publicRoot, $appUrl, $appEnv);
    }

    final private function __construct(
        private string $publicRoot,
        private string $appUrl,
        private string $appEnv
    ) {
    }

//     public function isMissingFolders(): bool
//     {
//         return ! $this->hasRequiredFolders();
//     }
//
//     private function hasRequiredFolders(): bool
//     {
//         return $this->publicRootFileInfo()->isDir();
//     }

    public function appUrl(): string
    {
        return $this->appUrl;
    }

    public function contentFileName(): string
    {
        return self::CONTENT_FILENAME;
    }

    public function contentRoot(): string
    {
        $parts = explode(self::FILE_SEPARATOR, $this->publicRoot());
        $parts = array_slice($parts, 0, -1);
        return implode(self::FILE_SEPARATOR, $parts);
    }

    public function publicRoot(): string
    {
        if ($realPath = $this->publicRootFileInfo()->getRealPath()) {
            return $realPath;
        }
        return '';
    }

    private function publicRootFileInfo(): SplFileInfo
    {
        if (! isset($this->publicRootFileInfo)) {
            $fileInfo = new SplFileInfo($this->publicRoot);
            $this->publicRootFileInfo = $fileInfo;
        }
        return $this->publicRootFileInfo;
    }
}
