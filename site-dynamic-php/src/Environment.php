<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic;

use SplFileInfo;

class Environment
{
    public const CONTENT_FILENAME = 'content.md';

    private const FILE_SEPARATOR = '/';

    private SplFileInfo $contentPublicFileInfo;

    public static function with(
        string $contentPublic,
        string $indexPublic,
        string $appUrl
    ): Environment {
        return new Environment($contentPublic, $indexPublic, $appUrl);
    }

    final private function __construct(
        private string $contentPublic,
        private string $indexPublic,
        private string $appUrl
    ) {
    }

    public function isMissingFolders(): bool
    {
        return ! $this->hasRequiredFolders();
    }

    private function hasRequiredFolders(): bool
    {
        return $this->contentPublicFileInfo()->isDir();
    }

    public function appUrl(): string
    {
        return $this->appUrl;
    }

    public function contentFileName(): string
    {
        return self::CONTENT_FILENAME;
    }

    /**
     * @todo: Use as path to error-500.html to respond when folders are missing.
     */
    public function indexPublic(): string
    {
        return $this->indexPublic;
    }

    public function contentRoot(): string
    {
        $parts = explode(self::FILE_SEPARATOR, $this->contentPublic());
        $parts = array_slice($parts, 0, -1);
        return implode(self::FILE_SEPARATOR, $parts);
    }

    public function contentPublic(): string
    {
        if ($realPath = $this->contentPublicFileInfo()->getRealPath()) {
            return $realPath;
        }
        return '';
    }

    public function contentPrivate(): string
    {
        $contentPublic = $this->contentPublic();
        if (strlen($contentPublic) > 0) {
            $parts = explode('/', $contentPublic);
            array_pop($parts);
            $parts[] = 'private';
            return implode('/', $parts);
        }
        return '';
    }

    private function contentPublicFileInfo(): SplFileInfo
    {
        if (! isset($this->contentPublicFileInfo)) {
            $fileInfo = new SplFileInfo($this->contentPublic);
            $this->contentPublicFileInfo = $fileInfo;
        }
        return $this->contentPublicFileInfo;
    }
}
