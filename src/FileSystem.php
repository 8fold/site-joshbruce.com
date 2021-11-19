<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use SplFileInfo;

use Symfony\Component\Finder\Finder;

use JoshBruce\Site\FileSystemInterface;

class FileSystem implements FileSystemInterface
{
    public static function init(): static
    {
        return new static(static::projectRoot());
    }

    public static function projectRoot(): string
    {
        $dir   = __DIR__;
        $parts = explode('/', $dir);
        $parts = array_slice($parts, 0, -1);
        return implode('/', $parts);
    }

    final private function __construct(protected string $projectRoot)
    {
    }

    public function hasRequiredFolders(): bool
    {
        return file_exists($this->contentRoot()) and
            file_exists($this->publicRoot()) and
            is_dir($this->contentRoot()) and
            is_dir($this->publicRoot());
    }

    public function contentRoot(): string
    {
        $parts   = explode('/', static::projectRoot());
        $parts[] = 'content';
        $base    = implode('/', $parts);
        if (str_ends_with($base, '/')) {
            $base = substr($base, 0, -1);
        }
        return $base;
    }

    public function publicRoot(): string
    {
        return $this->contentRoot() . '/public';
    }

    public function redirectedContentFinder(): Finder
    {
        return $this->finder()->contains('redirect: ');
    }

    public function publishedContentFinder(): Finder
    {
        return $this->finder()->in($this->publicRoot())->name('content.md')
            ->filter(fn($f) => $this->isPublished($f));
    }

    private function relativePath(string $path): string
    {
        return str_replace($this->contentRoot(), '', $path);
    }

    private function isPublished(SplFileInfo $finderFile): bool
    {
        return ! $this->isDraft($finderFile);
    }

    private function isDraft(SplFileInfo $finderFile): bool
    {
        $filePath = (string) $finderFile;
        $relativePath = $this->relativePath($filePath);
        return str_contains($relativePath, '_');
    }

    private function finder(): Finder
    {
        $finder = new Finder();
        return $finder->ignoreVCS(false)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->notName('.gitignore')
            ->files();
    }
}
