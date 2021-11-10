<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use SplFileInfo;

use Symfony\Component\Finder\Finder;

class FileSystem
{
    public static function init(): static
    {
        return new static(static::projectRoot());
    }

    public static function publicRoot(): string
    {
        return static::contentRoot() . '/public';
    }

    public static function contentRoot(): string
    {
        $parts   = explode('/', static::projectRoot());
        $parts[] = 'content';
        $base    = implode('/', $parts);
        if (str_ends_with($base, '/')) {
            $base = substr($base, 0, -1);
        }
        return $base;
    }

    public static function projectRoot(): string
    {
        $dir   = __DIR__;
        $parts = explode('/', $dir);
        $parts = array_slice($parts, 0, -1);
        return implode('/', $parts);
    }

    public static function finder(): Finder
    {
        $finder = new Finder();
        return $finder->ignoreVCS(false)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->notName('.gitignore')
            ->files()
            ->filter(fn($f) => self::isPublished($f))
            ->in(self::publicRoot());
    }

    private static function isPublished(SplFileInfo $finderFile): bool
    {
        return ! self::isDraft($finderFile);
    }

    private static function isDraft(SplFileInfo $finderFile): bool
    {
        $filePath = (string) $finderFile;
        $relativePath = self::relativePath($filePath);
        return str_contains($relativePath, '_');
    }

    private static function relativePath(string $path): string
    {
        return str_replace(self::contentRoot(), '', $path);
    }

    final private function __construct(protected string $projectRoot)
    {
    }
}
